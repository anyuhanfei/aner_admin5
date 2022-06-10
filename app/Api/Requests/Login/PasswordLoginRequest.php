<?php
namespace App\Api\Requests\Login;

use App\Api\Requests\BaseRequest;

class PasswordLoginRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'phone' => ['required', 'size:11'],
            'password' => ['required', new \App\Api\Rules\PasswordLoginVerify],
        ];
    }

    public function messages(){
        return [
            'phone.required'=> '请填写手机号',
            'password.required'=> '请填写密码'
        ];
    }
}