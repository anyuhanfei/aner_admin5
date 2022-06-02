<?php

namespace App\Admin\Repositories\Sys;

use App\Models\Sys\SysNotice as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class SysNotice extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
