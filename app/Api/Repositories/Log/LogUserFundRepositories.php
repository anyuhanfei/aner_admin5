<?php
namespace App\Api\Repositories\Log;

use App\Models\Log\LogUserFund as Model;
use Illuminate\Support\Facades\Cache;

class LogUserFundRepositories{
    protected $eloquentClass = Model::class;
    protected $cache_prefix = 'user_fund_log';

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
    public function create_data($uid, $coin_type, $money, $fund_type, $content, $remark = ''){
        $this->delete_cache($uid);
        return $this->eloquentClass::create([
            'uid'=> $uid,
            'coin_type'=> $coin_type,
            'number'=> $money,
            'fund_type'=> $fund_type,
            'content'=> $content,
            'remark'=> $remark
        ]);
    }

    /**
     * 获取日志列表
     *
     * @param int $uid 会员id
     * @param int $page 页面
     * @param int $limit 条数
     * @return void
     */
    public function get_list($uid, $page, $limit){
        return Cache::tags("{$this->cache_prefix}:{$uid}")->remember("{$this->cache_prefix}:{$uid}:{$page}:{$limit}", 86400, function() use($limit, $uid){
            return $this->eloquentClass::where('uid', $uid)->select(['number', 'coin_type', 'fund_type', 'created_at'])->orderBy('id', 'desc')->simplePaginate($limit);
        });
    }

    /**
     * 清除缓存
     *
     * @param int $uid 会员id
     * @return void
     */
    public function delete_cache($uid){
        Cache::tags(["{$this->cache_prefix}:{$uid}"])->flush();
        return true;
    }
}