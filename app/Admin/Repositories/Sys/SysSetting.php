<?php

namespace App\Admin\Repositories\Sys;

use App\Models\Sys\SysSetting as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Redis;

class SysSetting extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function get_parent($parent_id){
        return $this->eloquentClass::where('id', $parent_id)->first();
    }

    public function get_parent_list(){
        return $this->eloquentClass::where('parent_id', 0)->get()->pluck('title', 'id');
    }

    public function del_cache_data($id){
        Redis::del("setting:" . $id);
    }
}
