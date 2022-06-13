<?php
namespace App\Api\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Api\Controllers\BaseController;
use App\Models\Log\LogUserPay;
use App\Models\Sys\SysSetting;
use App\Models\User\UserFunds;

use Yansongda\Pay\Pay;

/**
 * 支付类
 * 以下支付后进行的逻辑处理均为充值功能的逻辑代码
 */
class PayController extends BaseController{
    public function ios_pay(Request $request){
        $price_array = [  # ios商品号=> 价格
            '20221'=> 6,
            '20222'=> 30,
            '20223'=> 68,
            '20224'=> 98,
            '20225'=> 198,
            '20226'=> 298,
        ];
        $receipt_data = $request->input('receipt-data', '');
        $itunes = 'https://buy.itunes.apple.com/verifyReceipt';  //正式
        $sandbox = 'https://sandbox.itunes.apple.com/verifyReceipt';  //沙箱
        $data = '{"receipt-data":"'.$receipt_data.'"}';
        $res = json_decode(https_request($itunes, $data), true);
        $err_msg = array(
            '21000' => 'App Store不能读取你提供的JSON对象',
            '21002' => 'receipt-data域的数据有问题1',
            '21003' => 'receipt无法通过验证',
            '21004' => '提供的shared secret不匹配你账号中的shared secret',
            '21005' => 'receipt服务器当前不可用',
            '21006' => 'receipt合法, 但是订阅已过期。服务器接收到这个状态码时, receipt数据仍然会解码并一起发送',
            '21007' => 'receipt是Sandbox receipt, 但却发送至生产系统的验证服务',
            '21008' => 'receipt是生产receipt, 但却发送至Sandbox环境的验证服务',
            '21199' => '21199'
        );
        // 0或 21007表示请求成功了
        if(intval($res['status']) === 0 || intval($res['status']) == 21007){
            $apple_order = $res['receipt']['in_app'][0];
            // 判断支付状态,成功则执行支付后代码
            $is_pay = false;
            if(intval($res['status']) === 0 && $apple_order['in_app_ownership_type'] == 'PURCHASED'){
                $is_pay = true;
            }
            if(intval($res['status']) == 21007){
                $is_pay = true;
            }
            if($is_pay){
                // 添加充值日志，并添加余额
                DB::beginTransaction();
                $pay_log = LogUserPay::create([
                    'order_no'=> $apple_order['transaction_id'],
                    'uid'=> $this->uid,
                    'type'=> 'IOS',
                    'order_type'=> '充值',
                    'money'=> $price_array[$apple_order['product_id']],
                    'platform'=> 'APP',
                    'status'=> 2
                ]);
                $res = UserFunds::update_data($this->uid, 'money', $price_array[$apple_order['product_id']], '充值', '充值');
                if($pay_log && $res){
                    DB::commit();
                }else{
                    DB::rollBack();
                }
            }else{
                return error('充值失败!');
            }
        }else{
            return error('支付失败!', ['error_code'=> $res['status'], 'error_msg'=> $err_msg[$res['status']]]);
        }
        return success('充值成功');
    }

    public function app_pay(\App\Api\Requests\PayRequest $request){
        $money = $request->input('money');
        $pay_type = $request->input('pay_type');
        $order_no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        $pay_log = LogUserPay::create([
            'order_no'=> $order_no,
            'uid'=> $this->uid,
            'type'=> $pay_type,
            'order_type'=> '充值',
            'money'=> $money,
            'platform'=> 'APP',
            'status'=> 1
        ]);
        if(!$pay_log){
            return error('操作失败');
        }
        $pay_params['subject'] = '充值';
        $pay_params['params'] = json_encode(['trade_type'=>'APP']);
        $pay_params['payment_id'] = $pay_log['order_no'];
        switch ($pay_type) {
            case '支付宝':
                $order = [
                    'out_trade_no' => $order_no,
                    'total_amount' => $money,
                    'subject' => '充值',
                ];
                $result = Pay::alipay()->web($order);
                break;
            case '微信':
                $order = [
                    'out_trade_no' => $order_no,
                    'body' => '充值',
                    'total_fee' => $money,
                    'openid' => 'onkVf1FjWS5SBIixxxxxxxxx',
                ];
                $result = Pay::wechat()->mp($order);
                break;
            default:
                $res = false;
                break;
        }
        return $res ? success('支付发起', $result) : error('支付发起失败');
    }
}
