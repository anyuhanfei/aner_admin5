<?php
namespace App\Api\Controllers;

use Illuminate\Support\Facades\DB;

use App\Api\Controllers\BaseController;
use App\Models\Sys\SysSetting;
use App\Models\User\UserFunds;

class UserController extends BaseController{
    public function detail(){
        return ['code'=> 200, 'msg'=> '会员详情', 'data'=> [$this->user]];
    }

    public function test(){
        DB::beginTransaction();
        $res = UserFunds::update_data($this->uid, 'money', 100, '测试');
        if($res){
            DB::commit();
        }else{
            DB::rollBack();
        }
    }
}
