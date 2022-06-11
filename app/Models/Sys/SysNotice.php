<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class SysNotice extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'sys_notice';
    protected $guarded = [];

    public static function init(){
        if(self::count() < 1){
            self::create([
                'title'=> '',
                'image'=> '',
                'content'=> '',
            ]);
        }
    }

    /**
     * 获取全部公告
     *
     * @return void
     */
    public static function getall(){
        do{
            $values = Redis::hvals("notice");
        }while(count($values) == 0 && self::setall());
        foreach ($values as $key => $value) {
            $values[$key] = json_decode($value);
        }
        return $values;
    }

    public static function getone($id){
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
    private static function setall(){
        foreach(self::all() as $item){
            self::setone(0, $item);
        }
        return true;
    }

    /**
     * 将一条数据添加到redis中（为了防止异常的id号导致死循环）
     *
     * @param [type] $itme
     * @return void
     */
    private static function setone($id, $item = null){
        $item = $item ?? self::find($id);
        return Redis::hmset('notice', ["{$item->id}"=> json_encode([
            'id'=> $item->id,
            'title'=> $item->title,
            'image'=> $item->image,
            'content'=> $item->content
        ])]);
    }
}
