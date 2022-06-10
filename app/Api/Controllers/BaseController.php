<?php
namespace App\Api\Controllers;

use App\Models\User\Users;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BaseController extends Controller{
    public function __construct(Request $request){
        // 获取当前登录的会员信息
        $this->uid = 0;
        $this->user = null;
        if($request->hasHeader('token')){
            $this->uid = Users::use_token_get_uid($request->header('token'));
        }
        if($this->uid != 0){
            $this->user = Users::find($this->uid);
        }
        // 获取部分系统设置
        $this->setting['identity_field'] = config('project.users.user_identity')[0];
    }

    /**
     * 发送短信验证码
     *
     * @param string $type 场景类型，register(注册), other(其他, 登录、忘记密码、修改密码等)
     * @param int $phone
     * @return void
     */
    public function send_sms(\App\Api\Requests\SendSmsRequest $request){
        $phone = $request->input('phone');
        $sms_code = rand(100000, 999999);
        Redis::setex("sms_code:{$sms_code}:{$phone}", 60 * 5, '');
        return success('发送成功');
    }
}
