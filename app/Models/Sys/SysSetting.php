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

    public static function get($id){
        $value = Redis::get("setting:{$id}");
        if($value == null){
            throw new Exception("系统设置获取错误", 1);
        }
        return $value;
    }
}
