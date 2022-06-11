<?php

namespace App\Models\Sys;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class SysSetting extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'sys_setting';
    protected $guarded = [];

    /**
     * 获取指定的系统设置
     *
     * @param int $id 系统设置id
     * @return void
     */
    public static function get($id){
        do{
            $value = Redis::get("setting:{$id}");
        }while($value === null && self::set_redis($id));
        return $value;
    }

    /**
     * 将数据添加到redis
     * 在后台编辑或添加都会加入redis，此项是为了防止获取无效的数据和redis没有持久化
     *
     * @param int $id 系统设置id
     * @return void
     */
    private static function set_redis($id){
        $res = Redis::setnx("setting:{$id}", self::where('id', $id)->value('value'));
        return $res;
    }
}
