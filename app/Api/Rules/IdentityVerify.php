<?php
namespace App\Api\Rules;

use App\Api\Repositories\User\UsersRepositories;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;


class IdentityVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        $user_repositories = new UsersRepositories();
        $data = $user_repositories->use_identity_get_data($value);
        if($data === false){
            return false;
        }
        switch($data['field']){
            case "phone":
                return preg_match('/^1[345789]\d{9}$/ims', $value);
            case "email":
                return preg_match('/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/ims', $value);
            default:
                return true;
        }
    }

    public function message(){
        return "账号或密码错误";
    }
}