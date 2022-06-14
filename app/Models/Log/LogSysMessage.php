<?php

namespace App\Models\Log;

use App\Models\User\Users;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LogSysMessage extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'log_sys_message';
    protected $guarded = [];

    public function user(){
        return $this->hasOne(Users::class, 'id', 'uid');
    }

}
