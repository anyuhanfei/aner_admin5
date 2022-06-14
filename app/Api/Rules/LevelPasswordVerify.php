<?php
namespace App\Api\Rules;

use App\Models\User\Users;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;


class LevelPasswordVerify implements Rule, DataAwareRule{
    protected $data = [];

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value){
        return $value == Users::where('id', $this->data['uid'])->value('level_password');
    }

    public function message(){
        return "原二级密码输入错误";
    }
}