<?php
namespace App\Api\Service;

use App\Api\Repositories\User\UsersRepositories;

class UserService{
    protected $repositories;

    public function __construct(){
        $this->repositories = new UsersRepositories();
    }

    /**
     * 修改会员数据
     *
     * @param eloquent $user_eloquent 会员model对象
     * @param array $field_values 字段和值组成键值对的数组
     * @return void
     */
    public function update_data($user_eloquent, $field_values){
        $data = [];
        foreach($field_values as $field=> $value){
            switch($field){
                case "password":
                    [$data['password'], $data['password_salt']] = $this->repositories->set_password($value);
                    break;
                default:
                    $data[$field] = $value;
                    break;
            }
        }
        return $this->repositories->update_data($user_eloquent, $data);
    }

    /**
     * 通过token获取到会员对象
     *
     * @param string $token token
     * @return void
     */
    public function use_token_get_user($token){
        $uid = $this->repositories->use_token_get_uid($token);
        $user = null;
        if($uid != 0){
            $user = $this->repositories->use_id_get_data($uid);
        }
        return $user;
    }
}