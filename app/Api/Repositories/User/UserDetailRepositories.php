<?php
namespace App\Api\Repositories\User;

use App\Models\User\UserDetail as Model;

class UserDetailRepositories{
    protected $eloquentClass = Model::class;

    /**
     * 创建数据
     *
     * @param int $uid 会员id
     * @return void
     */
    public function create_data($uid){
        return $this->eloquentClass::create([
            'id'=> $uid,
        ]);
    }
}