<?php
namespace App\Api\Requests;

use Illuminate\Support\Facades\Redis;

class SmsLoginRequest extends BaseRequest
{
    /**
     * 确定当前经过身份验证的用户是否可以执行请求操作
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 返回适用于请求数据的验证规则
     *
     * @return array
     */
    public function rules(){
        Redis::set('SmsLoginRequest:' . $this->all()['sms_code'], json_encode($this->all()), 10);
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