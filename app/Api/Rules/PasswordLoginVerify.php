<?php
namespace App\Api\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;

use App\Api\Repositories\User\UsersRepositories;


class PasswordLoginVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        $user_repositories = new UsersRepositories();
        $data = $user_repositories->use_identity_get_data($this->data['identity']);
        return $user_repositories->verify_password($user_repositories->get_data('id', $data['uid']), $value);
    }

    public function message(){
        return "账号或密码错误!";
    }
}