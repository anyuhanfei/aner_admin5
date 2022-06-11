<?php

namespace App\Models\Log;

use App\Models\User\Users;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class LogUserOperation extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'log_user_operation';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(Users::class);
    }
}
