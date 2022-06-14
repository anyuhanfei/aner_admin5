<?php
namespace App\Api\Rules;

use App\Models\User\Users;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\Redis;

class SmsCodeVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        if(empty($this->data['phone'])){
            $this->data['phone'] = Users::where('id', $this->data['uid'])->value('phone');
        }
        return Redis::get("sms_code:{$this->data['sms_code']}:{$this->data['phone']}") !== null;
    }

    public function message(){
        return '短信验证码输入错误';
    }
}