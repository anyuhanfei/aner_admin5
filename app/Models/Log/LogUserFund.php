<?php

namespace App\Models\Log;

use App\Models\User\Users;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LogUserFund extends Model
{
	use HasDateTimeFormatter;
    protected $table = 'log_user_fund';

    protected $guarded = [];

    public function user(){
        return $this->hasOne(Users::class, 'id', 'uid');
    }

    protected function CoinType(): Attribute{
        $coin_type = config('project.users.user_funds');
        return Attribute::make(
            get: fn ($value) => $coin_type[$value],
        );
    }

    /**
     * 将会员对资金的操作记录日志
     * 正常情况下仅被资金表的update_data()方法调用，无需自行调用此方法
     *
     * @param int $uid 会员id
     * @param string $coin_type 币种
     * @param float|int $money 金额
     * @param string $fund_type 操作类型
     * @param string $content 操作说明
     * @param string $remark 备注
     * @return void
     */
    public static function create_data($uid, $coin_type, $money, $fund_type, $content, $remark = ''){
        Cache::tags(['user_fund_log:' . $uid])->flush();
        return self::create([
            'uid'=> $uid,
            'coin_type'=> $coin_type,
            'number'=> $money,
            'fund_type'=> $fund_type,
            'content'=> $content,
            'remark'=> $remark
        ]);
    }
}
