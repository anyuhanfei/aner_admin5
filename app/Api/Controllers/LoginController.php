<?php
namespace App\Api\Controllers;

use App\Api\Controllers\BaseController;

use App\Api\Service\UserService;

use Illuminate\Http\Request;


class LoginController extends BaseController{
    public function __construct(Request $request){
        parent::__construct($request);
        $this->service = new UserService();
    }

    /**
     * 注册
     *
     * @return void
     */
    public function register(Request $request){
        $phone = $request->input('phone');
        $password = $request->input('password');
        Users::create_data($phone, $password);
        return response()->json(['code'=> 200, 'msg'=> '注册成功'], 200);
    }

    /**
     * 密码登录
     *
     * @return void
     */
    public function password_login(\App\Api\Requests\Login\PasswordLoginRequest $request){
        $identity = $request->input('identity', '');
        $password = $request->input('password', '');
        return success('登录成功', $this->service->login($this->setting['identity_field'], $identity, 'password'));
    }

    /**
     * 短信验证码登录
     *
     * @param Request $request
     * @return void
     */
    public function sms_login(\App\Api\Requests\Login\SmsLoginRequest $request){
        $phone = $request->input('phone');
        return success('登录成功', $this->service->login('phone', $phone, 'sms'));
    }

    /**
     * 一键登录
     * 前端获取token与accessToken，然后请求易盾的接口获取手机号信息
     *
     * @return void
     */
    public function oauth_login(Request $request){
        $token = $request->input('token', '');
        $accessToken = $request->input('accessToken', '');
        $res = \App\Api\Service\Trigonal\YidunMobileService::oauth($token, $accessToken);
        $phone = $res['data']['phone'];
        return success('登录成功', $this->service->login('phone', $phone, 'oauth'));
    }

    /**
     * 第三方登录
     * 前端上传第三方名称与相应的unionid，然后根据unionid获取会员信息
     *
     * @return void
     */
    public function third_party_login(Request $request){
        $login_type = $request->input('login_type', '');
        if (!in_array($login_type, ['weixin', 'qq', 'facebook', 'google', 'apple'])) {
            return $this->failed('请求方式错误');
        }
        $oauthUser = $this->service->get_third_party_data($login_type, $request->input('code', ''), [
            'access_token'=> $request->input('access_token', ''),
            'openid'=> $request->input('openid', ''),
        ]);
        if(is_string($oauthUser)){
            return error($oauthUser);
        }
        $user = $this->service->third_party_login($login_type, $oauthUser);
        return success('登录成功', $this->service->login('open_id', $user->open_id, 'third_party'));
    }
}
