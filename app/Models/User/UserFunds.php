<?php

namespace App\Models\User;

use App\Models\Log\LogUserFund;
use Illuminate\Database\Eloquent\Model;

class UserFunds extends Model{
    public $timestamps = false;
    protected $fillable = ['id'];

    public static function create_data($uid){
        return self::create([
            'id'=> $uid,
        ]);
    }

    /**
     * 对会员的资金进行操作并添加记录信息
     * 正常情况下，需要在事务内调用此方法，可以让悲观锁生效
     *
     * @param int $uid 会员id
     * @param string $coin_type 币种
     * @param float|int $money 金额
     * @param string $fund_type 操作类型
     * @param string $content 操作说明
     * @param string $remark 备注
     * @return bool
     */
    public static function update_data($uid, $coin_type, $money, $fund_type, $content = '', $remark = ''){
        $user_fund = self::where('id', $uid)->lockForUpdate()->first();
        $user_fund->$coin_type += $money;
        $res_one = $user_fund->save();
        $res_two = LogUserFund::create_data($uid, $coin_type, $money, $fund_type, $content == '' ? $fund_type : $content, $remark);
        return $res_one && $res_two;
    }
}
