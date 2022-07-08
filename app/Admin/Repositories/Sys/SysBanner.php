<?php

namespace App\Admin\Repositories\Sys;

use App\Models\Sys\SysBanner as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Redis;

class SysBanner extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function del_cache_data(){
        Redis::del("banner");
    }
}
