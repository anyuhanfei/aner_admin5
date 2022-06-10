<?php
namespace App\Api\Rules;

use App\Models\User\Users;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\Redis;


class SendSmsPhoneVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        $user = Users::where('phone', $value)->first();
        if($this->data['type'] == 'register'){
            return !boolval($user);
        }else{
            return boolval($user);
        }
    }

    public function message(){
        if($this->data['type'] == 'register'){
            return "此手机号已被注册";
        }else{
            return "此手机号未被注册";
        }
    }
}