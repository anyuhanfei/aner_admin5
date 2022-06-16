<?php
namespace App\Api\Requests\Login;

use App\Api\Requests\BaseRequest;

class PasswordLoginRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'identity' => ['required', new \App\Api\Rules\IdentityVerify],
            'password' => ['required', new \App\Api\Rules\PasswordLoginVerify],
        ];
    }

    public function messages(){
        return [
            'identity.required'=> '请填写手机号',
            'password.required'=> '请填写密码'
        ];
    }
}