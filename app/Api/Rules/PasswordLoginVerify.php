<?php
namespace App\Api\Rules;

use App\Models\User\Users;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Support\Facades\Redis;


class PasswordLoginVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        $user = Users::get_data('phone', $this->data['phone']);
        if(!$user){
            return false;
        }
        return Users::verify_password($user, $value);
    }

    public function message(){
        return "账号或密码错误";
    }
}