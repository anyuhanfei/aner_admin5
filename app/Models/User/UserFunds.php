<?php

namespace App\Models\User;

use App\Models\Log\LogUserFund;
use Illuminate\Database\Eloquent\Model;

class UserFunds extends Model{
    public $timestamps = false;
    protected $fillable = ['id'];
}
