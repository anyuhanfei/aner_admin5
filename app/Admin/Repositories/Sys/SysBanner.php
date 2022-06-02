<?php

namespace App\Admin\Repositories\Sys;

use App\Models\Sys\SysBanner as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class SysBanner extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
