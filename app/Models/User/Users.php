<?php

namespace App\Models\User;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

use App\Models\Log\LogUserFund;
use App\Models\Log\LogUserOperation;
use App\Models\User\UserFunds;
use App\Models\User\UserDetail;
use Illuminate\Support\Facades\Redis;

class Users extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $guarded = [];


    public function funds(){
        return $this->hasOne(UserFunds::class, 'id', 'id');
    }

    public function detail(){
        return $this->hasOne(UserDetail::class, 'id', 'id');
    }

    public function parent(){
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function log_fund(){
        return $this->hasMany(LogUserFund::class, 'id', 'uid');
    }

    public function log_operation(){
        return $this->hasMany(LogUserOperation::class, 'id', 'uid');
    }

    /**
     * 密码加密
     *
     * @param string $password 密码原码
     * @param string $salt 盐
     * @return string 加密密码
     */
    public static function encryption_password($password, $salt){
        return md5(md5($password) . $salt);
    }

    /**
     * 生成密码
     *
     * @param string $password 密码原码
     * @return array 加密密码, 盐
     */
    public static function set_password($password){
        $salt = rand(10000, 999999);
        return [self::encryption_password($password, $salt), $salt];
    }

    /**
     * 设置会员的token
     *
     * @param int $uid 会员id
     * @return void
     */
    public static function set_token($uid){
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
    public static function delete_token($uid){
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
    public static function use_token_get_uid($token){
        $uid = Redis::get('user_token:' . $token);
        return $uid ?? 0;
    }

    /**
     * 通过会员的id获取token
     *
     * @param int $uid 会员id
     * @return void
     */
    public static function use_uid_get_token($uid){
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
    public static function create_data($identity, $password = '', $parent_id = 0, $param = []){
        $password = $password == '' ? create_captcha(9, 'lowercase+uppercase+figure') : $password;
        [$password, $password_salt] = self::set_password($password);
        $identity_field = config('project.users.user_identity')[0];
        $obj = Users::create(array_merge([
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
    public static function verify_password($user_obj, $password){
        return self::encryption_password($password, $user_obj->password_salt) == $user_obj->password;
    }
}
