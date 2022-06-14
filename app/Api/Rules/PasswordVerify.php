<?php
namespace App\Api\Rules;

use App\Api\Repositories\User\UsersRepositories;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;


class PasswordVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        $UsersRepositories = new UsersRepositories();
        $user = $UsersRepositories->get_data('id', $this->data['uid'], ['password', 'password_salt']);
        if(!$user){
            return false;
        }
        return $UsersRepositories->verify_password($user, $value);
    }

    public function message(){
        return "账号或密码错误";
    }
}