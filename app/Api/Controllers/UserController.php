<?php
namespace App\Api\Controllers;

use App\Api\Controllers\BaseController;

class UserController extends BaseController{
    public function detail(){
        return ['code'=> 200, 'msg'=> '会员详情', 'data'=> [$this->user]];
    }
}
