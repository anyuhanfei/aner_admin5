<?php
namespace App\Api\Requests\Login;

use App\Api\Requests\BaseRequest;

class SmsLoginRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'phone' => 'required',
            'sms_code' => ['required', new \App\Api\Rules\SmsCodeVerify],
        ];
    }

    public function messages(){
        return [
            'phone.required'=> '请填写手机号',
            'sms_code.required'=> '请填写短信验证码'
        ];
    }
}