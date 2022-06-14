<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model{
    public $timestamps = false;
    protected $guarded = [];
    protected $table = "user_detail";

}
