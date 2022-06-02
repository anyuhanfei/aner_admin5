<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserFunds extends Model{
    public $timestamps = false;
    protected $fillable = ['id'];

    public static function create_data($uid){
        return self::create([
            'id'=> $uid,
        ]);
    }
}
