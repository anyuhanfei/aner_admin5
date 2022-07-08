<?php

namespace App\Admin\Repositories;

use App\Models\User\Users as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class User extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function get_parent_list(){
        return $this->eloquentClass::all()->pluck('nickname', 'id');
    }
}
