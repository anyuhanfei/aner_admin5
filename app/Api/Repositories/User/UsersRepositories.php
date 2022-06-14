<?php

namespace App\Api\Repositories\User;

use App\Models\User\Users as Model;
use App\Models\User\UserFunds;
use App\Models\User\UserDetail;

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
        return [self::encryption_password($password, $salt), $salt];
    }

    /**
     * 设置会员的token
     *
     * @param int $uid 会员id
     * @return void
     */
    public function set_token($uid){
        self::delete_token($uid);
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
        $token = self::use_uid_get_token($uid);
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
     * 验证密码
     *
     * @param Eloquent $user_obj 会员数据对象
     * @param string $password 密码原码
     * @return void
     */
    public function verify_password($user_obj, $password){
        return self::encryption_password($password, $user_obj->password_salt) == $user_obj->password;
    }

    /**
     * 获取指定数据
     *
     * @param [type] $field
     * @param [type] $value
     * @return void
     */
    public function get_data($field, $value){
        if($field != 'id'){
            $value = $this->eloquentClass::where($field, $value)->value('id');
            $field = 'id';
        }
        $user_obj = json_decode(Redis::get('user_data:' . $value));
        if($user_obj === null){
            $user_obj = $this->eloquentClass::find($value);
            if(!$user_obj){
                return $user_obj;
            }
            Redis::set('user_data:' . $value, $user_obj->toJson());
        }
        return $user_obj;
    }

    public function use_id_get_data($uid, $select=['*']){
        return $this->eloquentClass::select($select)->find($uid);
    }

    /**
     * 传入要修改的字段与值，修改
     *
     * @param [type] $user_eloquent
     * @param [type] $data
     * @return void
     */
    public function update_data($user_eloquent, $data){
        foreach ($data as $key => $value) {
            $user_eloquent->$key = $value;
        }
        return $user_eloquent->save();
    }
}
