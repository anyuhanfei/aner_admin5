<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model{
    public $timestamps = false;
    protected $fillable = ['id'];
    protected $table = "user_detail";

    public static function create_data($uid){
        return self::create([
            'id'=> $uid,
        ]);
    }
}
