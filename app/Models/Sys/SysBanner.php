<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class SysBanner extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'sys_banner';
    protected $guarded = [];

    /**
     * 获取全部banner（所有场景都是获取所有的banner图）
     *
     * @return void
     */
    public static function getall(){
        do{
            $values = Redis::hvals("banner");
        }while(count($values) == 0 && self::setall());
        foreach ($values as $key => $value) {
            $values[$key] = json_decode($value);
        }
        return $values;
    }

    /**
     * 将全部数据添加到redis
     * 后台修改banner图后，会将缓存删除
     *
     * @return void
     */
    private static function setall(){
        foreach(self::all() as $item){
            Redis::hmset('banner', ["{$item->id}"=> json_encode(['image'=> $item->image, 'url'=> $item->url])]);
        }
        return true;
    }
}
