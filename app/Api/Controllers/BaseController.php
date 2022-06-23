<?php
namespace App\Api\Controllers;

use App\Api\Service\UserService;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Api\Service\Trigonal\SmsService;


class BaseController extends Controller{
    public function __construct(Request $request){
        // 获取当前登录的会员信息
        if($request->hasHeader('token')){
            $user_service = new UserService();
            $this->uid = $user_service->use_token_get_uid($request->header('token'));
        }else{
            $this->uid = 0;
        }
        // 获取部分系统设置
        $this->setting['identity_field'] = config('admin.users.user_identity')[0];
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
        $sms_service = new SmsService();
        $sms_service->send_sms($phone);
        return success('发送成功');
    }
}
