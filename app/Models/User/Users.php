<?php

namespace App\Models\User;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;


use App\Models\Log\LogUserFund;
use App\Models\Log\LogUserOperation;


class Users extends Model{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $guarded = [];


    public function funds(){
        return $this->hasOne(UserFunds::class, 'id', 'id');
    }

    public function detail(){
        return $this->hasOne(UserDetail::class, 'id', 'id');
    }

    public function parent(){
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function log_fund(){
        return $this->hasMany(LogUserFund::class, 'id', 'uid');
    }

    public function log_operation(){
        return $this->hasMany(LogUserOperation::class, 'id', 'uid');
    }
}
