<?php
namespace App\Api\Repositories\Sys;

use App\Models\Sys\SysNotice as Model;
use Illuminate\Support\Facades\Redis;

class SysNoticeRepositories{
    protected $eloquentClass = Model::class;

    /**
     * 获取全部公告
     *
     * @return void
     */
    public function getall(){
        do{
            $values = Redis::hvals("notice");
        }while(count($values) == 0 && $this->setall());
        foreach ($values as $key => $value) {
            $values[$key] = json_decode($value);
        }
        return $values;
    }

    public function getone($id){
        do{
            $value = Redis::hget("notice", $id);
        }while($value === null && self::setone($id));
        return json_decode($value);
    }

    /**
     * 将全部数据添加到redis
     * 后台修改数据后，会将缓存删除
     *
     * @return void
     */
    private function setall(){
        foreach($this->eloquentClass::all() as $item){
            $this->setone(0, $item);
        }
        return true;
    }

    /**
     * 将一条数据添加到redis中（为了防止异常的id号导致死循环）
     *
     * @param [type] $itme
     * @return void
     */
    private function setone($id, $item = null){
        $item = $item ?? $this->eloquentClass::find($id);
        return Redis::hmset('notice', ["{$item->id}"=> json_encode([
            'id'=> $item->id,
            'title'=> $item->title,
            'image'=> $item->image,
            'content'=> $item->content
        ])]);
    }
}