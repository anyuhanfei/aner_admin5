<?php

namespace App\Models\Log;

use App\Models\User\Users;
use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class LogUserFund extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'log_user_fund';

    public function user(){
        return $this->hasOne(Users::class, 'id', 'uid');
    }
}
