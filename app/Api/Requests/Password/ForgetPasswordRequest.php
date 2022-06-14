<?php
namespace App\Api\Requests\Password;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

use App\Api\Requests\BaseRequest;

class ForgetPasswordRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'sms_code' => ['required', new \App\Api\Rules\SmsCodeVerify],
            'password' => ['required', Password::min(8), 'confirmed:password_confirmation'],
            'password_confirmation' => ['required']
        ];
    }

    public function messages(){
        return [
            'sms_code.required'=> '请填写短信验证码',
            'password.required'=> '请填写新密码',
            'password.min'=> '密码至少8位',
            'password.confirmed'=> '确认密码与密码填写不一致',
            'password_confirmation.required'=> '请填写确认密码',
        ];
    }
}