<?php

namespace App\Models\Log;

use App\Models\User\Users;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class LogUserPay extends Model{
	use HasDateTimeFormatter;
    protected $table = 'log_user_pay';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(Users::class);
    }
}
