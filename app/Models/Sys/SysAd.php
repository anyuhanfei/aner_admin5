<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\ModelTree;
use Exception;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SysAd extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;
    use ModelTree;

    protected $table = 'sys_ad';
    protected $titleColumn = 'title';
    protected $parentColumn = 'parent_id';
    protected $guarded = [];

    public function getOrderColumn(){
        return null;
    }

    /**
     * 获取指定id的数据
     *
     * @param int $id 广告id
     * @return void
     */
    public static function getone($id){
        do{
            $value = Redis::hgetall('ad:' . $id);
        }while(count($value) == 0 && self::setone($id));
        return $value;
    }

    /**
     * 将指定数据添加到redis
     * 如果是广告位，则获取广告位下的所有广告并存储
     *
     * @param int $id 广告id
     * @return void
     */
    private static function setone($id){
        $value = self::find($id);
        if(!$value){
            return Redis::hmset("ad:{$id}", []);
        }
        if($value->parent_id == 0){
            $items = self::where('parent_id', $value->id)->get();
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
