<?php
namespace App\Api\Requests\Password;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

use App\Api\Requests\BaseRequest;

class UpdateLevelPasswordRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'old_password' => ['required', new \App\Api\Rules\LevelPasswordVerify],
            'password' => ['required', 'digits:6', 'confirmed:password_confirmation', 'different:old_password'],
            'password_confirmation' => ['required']
        ];
    }

    public function messages(){
        return [
            'old_password.required'=> '请填写原密码',
            'password.required'=> '请填写新密码',
            'password.digits'=> '密码必须是6位',
            'password.confirmed'=> '确认密码与密码填写不一致',
            'password.different'=> '新密码不能与旧密码相同',
            'password_confirmation.required'=> '请填写确认密码',
        ];
    }
}