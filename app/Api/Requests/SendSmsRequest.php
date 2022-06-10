<?php
namespace App\Api\Requests;

use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rule;

class SendSmsRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'phone' => ['required', 'size:11', new \App\Api\Rules\SendSmsPhoneVerify],
            'type' => ['required', Rule::in(['register', 'other'])],
        ];
    }

    public function messages(){
        return [
            'phone.required'=> '请填写手机号',
            'phone.size'=> '手机号格式不正确',
            'type.required'=> '请指定操作场景',
            'type.in'=> '操作场景指定错误',
        ];
    }
}