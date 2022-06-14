<?php
namespace App\Api\Repositories\User;

use App\Models\User\UserDetail as Model;

class UserDetailRepositories{
    protected $eloquentClass = Model::class;

    public function create_data($uid){
        return $this->eloquentClass::create([
            'id'=> $uid,
        ]);
    }
}