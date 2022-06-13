<?php
namespace App\Api\Requests;

use Illuminate\Validation\Rule;

class PayRequest extends BaseRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            'money' => ['required', 'min:0.01'],
            'pay_type' => ['required', Rule::in(['微信', '支付宝'])],
        ];
    }

    public function messages(){
        return [
            'money.required'=> '请填写金额',
            'money.min'=> '金额必须大于0',
            'pay_type.required'=> '请指定支付平台',
            'type.in'=> '当前支付平台未开放',
        ];
    }
}