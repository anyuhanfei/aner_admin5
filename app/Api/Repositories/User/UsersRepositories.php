<?php

namespace App\Api\Repositories\User;

use App\Models\User\Users as Model;
use App\Models\User\UserFunds;
use App\Models\User\UserDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Hash;


class UsersRepositories{
    protected $eloquentClass = Model::class;

    /**
     * 密码加密
     *
     * @param string $password 密码原码
     * @param string $salt 盐
     * @return string 加密密码
     */
    public function encryption_password($password, $salt){
        return md5(md5($password) . $salt);
    }

    /**
     * 生成密码
     *
     * @param string $password 密码原码
     * @return array 加密密码, 盐
     */
    public function set_password($password){
        $salt = rand(10000, 999999);
        return [$this->encryption_password($password, $salt), $salt];
    }

    /**
     * 验证密码
     *
     * @param Eloquent $user_obj 会员数据对象
     * @param string $password 密码原码
     * @return void
     */
    public function verify_password($user_obj, $password){
        return $this->encryption_password($password, $user_obj->password_salt) == $user_obj->password;
    }

    /**
     * 设置会员的token
     *
     * @param int $uid 会员id
     * @return void
     */
    public function set_token($uid){
        $this->delete_token($uid);
        $user_token = md5(Hash::make(time()));
        Redis::set('user_token:' . $user_token, $uid);
        Redis::set('user_token:' . $uid, $user_token);
        return $user_token;
    }

    /**
     * 删除会员的token信息
     *
     * @param int $uid 会员id
     * @return void
     */
    public function delete_token($uid){
        $token = $this->use_uid_get_token($uid);
        Redis::delete('user_token:' . $token);
        Redis::delete('user_token:' . $uid);
        return true;
    }

    /**
     * 通过token获取会员的id
     *
     * @param string $token token
     * @return void
     */
    public function use_token_get_uid($token){
        $uid = Redis::get('user_token:' . $token);
        return $uid ?? 0;
    }

    /**
     * 通过会员的id获取token
     *
     * @param int $uid 会员id
     * @return void
     */
    public function use_uid_get_token($uid){
        $token = Redis::get('user_token:' . $uid);
        return $token ?? '';
    }

    /**
     * 创建会员，并创建相关数据
     *
     * @param string $identity 会员标识，在config/project.php 中可设置
     * @param string $password 密码原码，如果不传则随机生成
     * @param integer $parent_id 上级会员id
     * @param array $param 创建会员的其他信息
     * @return void
     */
    public function create_data($identity, $password = '', $parent_id = 0, $param = []){
        $password = $password == '' ? create_captcha(9, 'lowercase+uppercase+figure') : $password;
        [$password, $password_salt] = self::set_password($password);
        $identity_field = config('project.users.user_identity')[0];
        $obj = $this->eloquentClass::create(array_merge([
            $identity_field=> $identity,
            'password'=> $password,
            'password_salt'=> $password_salt,
            'parent_id'=> $parent_id
        ], $param));
        UserFunds::create(['id'=> $obj->id]);
        UserDetail::create(['id'=> $obj->id]);
        return $obj;
    }

    /**
     * 通过会员标识获取会员id
     *
     * @param string $field 字段
     * @param string $value 值
     * @return void
     */
    public function use_field_get_id($field, $value){
        return Cache::remember("user_identity:{$field}:{$value}", 86400, function() use($field, $value){
            return $this->eloquentClass::where($field, $value)->value('id');
        });
    }

    /**
     * 通过指定字段获取会员信息
     *
     * @param string $field 字段
     * @param string $value 值
     * @return void
     */
    public function get_data($field, $value, $select = ['*']){
        if($field != 'id'){
            $value = $this->use_field_get_id($field, $value);
            $field = 'id';
        }
        $user = Cache::remember("user_data:{$value}", 86400, function() use($value){
            return $this->eloquentClass::find($value);
        });
        $data = [];
        foreach ($select as $value) {
            if($value == "*"){
                $data = $user;
                unset($data['password']);
                unset($data['level_password']);
                unset($data['password_salt']);
                break;
            }
            $data[$value] = $user->$value;
        }
        return json_decode(json_encode($data));
    }


    /**
     * 通过输入的会员标识获取具体的字段和会员id
     *
     * @param [type] $value
     * @return void
     */
    public function use_identity_get_data($value){
        $identity_type = config('project.users.user_identity');
        foreach($identity_type as $v){
            $uid = $this->use_field_get_id($v, $value);
            if($uid){
                return ['field'=> $v, 'value'=> $value, 'uid'=> $uid];
            }
        }
        return false;
    }


    /**
     * 传入要修改的字段与值，修改
     *
     * @param [type] $user_eloquent
     * @param [type] $data
     * @return void
     */
    public function update_data($uid, $data){
        $this->delete_cache($uid);
        return $this->eloquentClass::where('id', $uid)->update($data);
    }

    /**
     * 删除缓存中的会员信息
     *
     * @param [type] $id
     * @return void
     */
    public function delete_cache($id){
        Cache::forget('user_data:' . $id);
        return true;
    }
}
