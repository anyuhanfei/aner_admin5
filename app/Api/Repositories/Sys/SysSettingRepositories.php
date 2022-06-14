<?php
namespace App\Api\Repositories\Sys;

use App\Models\Sys\SysSetting as Model;
use Illuminate\Support\Facades\Redis;

class SysSettingRepositories{
    protected $eloquentClass = Model::class;

    /**
     * 获取指定的系统设置
     *
     * @param int $id 系统设置id
     * @return void
     */
    public function get($id){
        do{
            $value = Redis::get("setting:{$id}");
        }while($value === null && $this->set_redis($id));
        return $value;
    }

    /**
     * 将数据添加到redis
     * 在后台编辑或添加都会加入redis，此项是为了防止获取无效的数据和redis没有持久化
     *
     * @param int $id 系统设置id
     * @return void
     */
    private function set_redis($id){
        $res = Redis::setnx("setting:{$id}", $this->eloquentClass::where('id', $id)->value('value'));
        return $res;
    }
}