<?php
namespace App\Api\Repositories\Sys;

use App\Models\Sys\SysAd as Model;
use Illuminate\Support\Facades\Redis;

class SysAdRepositories{
    protected $eloquentClass = Model::class;

    /**
     * 获取指定id的数据
     *
     * @param int $id 广告id
     * @return void
     */
    public function getone($id){
        do{
            $value = Redis::hgetall('ad:' . $id);
        }while(count($value) == 0 && $this->setone($id));
        return $value;
    }

    /**
     * 将指定数据添加到redis
     * 如果是广告位，则获取广告位下的所有广告并存储
     *
     * @param int $id 广告id
     * @return void
     */
    private function setone($id){
        $value = $this->eloquentClass::find($id);
        if(!$value){
            return Redis::hmset("ad:{$id}", []);
        }
        if($value->parent_id == 0){
            $items = $this->eloquentClass::where('parent_id', $value->id)->get();
            foreach ($items as $key => $item) {
                Redis::hmset("ad:{$value->id}", ["{$item->id}"=> json_encode([
                    'title'=> $item->title,
                    'image'=> $item->image,
                    'content'=> $item->content,
                ])]);
            }
        }else{
            Redis::hmset("ad:{$value->id}", [
                'title'=> $value->title,
                'image'=> $value->image,
                'content'=> $value->content,
            ]);
        }
        return true;
    }
}