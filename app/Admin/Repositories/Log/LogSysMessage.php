<?php

namespace App\Admin\Repositories\Log;

use App\Models\Log\LogSysMessage as Model;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Cache;

class LogSysMessage extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function del_cache_data($id = 0){
        if($id == 0){
            Cache::tags(["sys_message"])->flush();
        }else{
            Cache::tags(["sys_message:{$id}"])->flush();
        }
    }
}
