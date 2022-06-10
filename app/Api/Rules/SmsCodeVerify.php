<?php
namespace App\Api\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Redis;

class SmsCodeVerify implements Rule{
    /**
     * 判断验证规则是否通过。
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        $data = json_decode(Redis::get('SmsLoginRequest:' . $value));
        if($data == null){
            return false;
        }
        return Redis::get("sms_code:{$data->sms_code}:{$data->phone}") !== null;
    }

    /**
     * 获取验证错误消息。
     *
     * @return string
     */
    public function message()
    {
        return '短信验证码输入错误';
    }
}