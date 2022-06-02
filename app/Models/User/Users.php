<?php

namespace App\Models\User;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;


    public function funds(){
        return $this->hasOne(UserFunds::class, 'id', 'id');
    }

    public function detail(){
        return $this->hasOne(UserDetail::class, 'id', 'id');
    }

    public function parent(){
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public static function admin_set_password($password){
        $salt = rand(10000, 999999);
        return [md5(md5($password) . $salt), $salt];
    }
}
