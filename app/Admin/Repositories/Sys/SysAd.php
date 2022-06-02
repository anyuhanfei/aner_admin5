<?php

namespace App\Admin\Repositories\Sys;

use App\Models\Sys\SysAd as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class SysAd extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
