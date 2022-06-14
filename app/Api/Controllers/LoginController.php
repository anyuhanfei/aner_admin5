<?php
namespace App\Api\Controllers;

use App\Api\Controllers\BaseController;

use App\Models\User\Users;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController{
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
        $phone = $request->input('phone', '');
        $password = $request->input('password', '');
        //获取会员信息并验证
        $user = Users::where($this->setting['identity_field'], $phone)->first();
        //生成token并绑定
        $token = Users::set_token($user->id);
        //返回信息
        return success('登录成功', array_merge(self::return_user_data($user), [
            'user_token'=> $token,
        ]));
    }

    /**
     * 短信验证码登录
     *
     * @param Request $request
     * @return void
     */
    public function sms_login(\App\Api\Requests\Login\SmsLoginRequest $request){
        $phone = $request->input('phone');
        $user = Users::where('phone', $phone)->first();
        $is_register = 0;
        if(!$user){  // 注册
            $user = Users::create_data($phone);
            $is_register = 1;
        }
        $token = Users::set_token($user->id);
        return success('登录成功', array_merge(self::return_user_data($user), [
            'user_token'=> $token,
            'is_register'=> $is_register,
        ]));
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
        $res = \App\Api\Service\YidunMobileService::oauth($token, $accessToken);
        if($res['code'] == 200){
            $phone = $res['data']['phone'];
            $user = Users::where('phone', $phone)->first();
            $is_register = 0;
            if(!$user){  // 注册
                $user = Users::create_data($phone);
                $is_register = 1;
            }
            //登录
            $token = Users::set_token($user->id);
            return success('登录成功', array_merge(self::return_user_data($user), [
                'user_token'=> $token,
                'is_register'=> $is_register,
            ]));
        }
        return error('登录失败', $res);
    }

    /**
     * 第三方登录
     * 前端上传第三方名称与相应的unionid，然后根据unionid获取会员信息
     *
     * @return void
     */
    public function third_party_login(Request $request){
        $login_type = $request->input('login_type');
        $unionid = $request->input('unionid');
        $user = Users::where('unionid', $unionid)->first();
        $is_register = 0;
        if(!$user){
            $user = Users::create_data('', '', 0, ['login_type'=> $login_type, 'unionid'=> $unionid]);
            $is_register = 1;
        }
        $token = Users::set_token($user->id);
        return success('登录成功', array_merge(self::return_user_data($user), [
            'user_token'=> $token,
            'is_register'=> $is_register
        ]));
    }

    /**
     * 登录后返回的会员数据
     *
     * @param Eloquent $user_obj
     * @return void
     */
    private static function return_user_data($user_obj){
        return [
            'uid'=> $user_obj->id,
            'avatar'=> $user_obj->avatar,
            'phone'=> $user_obj->phone,
            'avatar'=> $user_obj->avatar,
        ];
    }
}
