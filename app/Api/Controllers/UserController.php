<?php
namespace App\Api\Controllers;

use Illuminate\Support\Facades\DB;

use App\Api\Controllers\BaseController;
use App\Models\Sys\SysSetting;
use App\Models\User\UserFunds;
use App\Models\User\Users;
use Illuminate\Http\Request;

use App\Api\Service\UserService;

class UserController extends BaseController{
    protected $service;

    public function __construct(Request $request){
        parent::__construct($request);
        $this->service = new UserService();
    }

    public function detail(){
        return ['code'=> 200, 'msg'=> '会员详情', 'data'=> [$this->user]];
    }

    /**
     * 修改密码，输入旧密码和新密码
     *
     * @param \App\Api\Requests\Password\UpdatePasswordRequest $request
     * @return void
     */
    public function update_password(\App\Api\Requests\Password\UpdatePasswordRequest $request){
        $password = $request->input('password');
        return $this->service->update_data($this->user, ['password'=> $password]) ? success('密码修改成功') : error('密码修改失败');
    }

    /**
     * 忘记密码，输入手机验证码和新密码
     *
     * @param \App\Api\Requests\Password\ForgetPasswordRequest $request
     * @return void
     */
    public function forget_password(\App\Api\Requests\Password\ForgetPasswordRequest $request){
        $password = $request->input('password');
        return $this->service->update_data($this->user, ['password'=> $password]) ? success('密码修改成功') : error('密码修改失败');
    }

    /**
     * 修改二级密码(支付密码)，输入旧密码和密码
     *
     * @param \App\Api\Requests\Password\UpdateLevelPasswordRequest $request
     * @return void
     */
    public function update_level_password(\App\Api\Requests\Password\UpdateLevelPasswordRequest $request){
        $password = $request->input('password');
        return $this->service->update_data($this->user, ['level_password'=> $password]) ? success('二级密码修改成功') : error('二级密码修改失败');
    }

    /**
     * 忘记二级密码，输入短信验证码与新密码
     *
     * @param \App\Api\Requests\Password\ForgetLevelPasswordRequest $request
     * @return void
     */
    public function forget_level_password(\App\Api\Requests\Password\ForgetLevelPasswordRequest $request){
        $password = $request->input('password');
        return $this->service->update_data($this->user, ['level_password'=> $password]) ? success('二级密码修改成功') : error('二级密码修改失败');
    }
}
