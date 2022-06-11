<?php

namespace App\Models\Log;

use App\Models\User\Users;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class LogSysMessage extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'log_sys_message';
    protected $guarded = [];

    public function user(){
        return $this->hasOne(Users::class, 'id', 'uid');
    }

    public static function get_read_status($uid, $id){
        return Redis::sismember('sys_message_read:' . $uid, $id);
    }

    public static function set_read_status($uid, $id){
        return Redis::sadd('sys_message_read:' . $uid, $id);
    }
}
