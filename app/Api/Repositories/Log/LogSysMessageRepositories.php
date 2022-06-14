<?php
namespace App\Api\Repositories\Log;

use App\Models\Log\LogSysMessage as Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class LogSysMessageRepositories{
    protected $eloquentClass = Model::class;

    /**
     * 获取系统消息列表
     *
     * @param int $uid 会员id
     * @param int $page 页码
     * @param int $limit 条数
     * @return array
     */
    public function get_list($uid, $page, $limit){
        return Cache::tags(["sys_message", "sys_message:{$uid}"])->remember("sys_message:{$uid}:{$page}:{$limit}", 86400, function() use($limit, $uid){
            $select = ['id', 'title', 'image', 'created_at'];
            return $this->eloquentClass::whereIn('uid', [0, $uid])->select($select)->orderBy('id', 'desc')->simplePaginate($limit);
        });
    }

    /**
     * 获取一条系统消息
     *
     * @param int $uid 会员id
     * @param int $id 系统消息id
     * @return object
     */
    public function get_one($uid, $id){
        return Cache::remember("sys_message_id:{$id}", 86400, function() use($uid, $id){
            $select = ['id', 'title', 'image', 'created_at'];
            return $this->eloquentClass::whereIn('uid', [0, $uid])->where('id', $id)->select($select)->first();
        });
    }

    /**
     * 删除缓存数据
     *
     * @param int $uid 会员id
     * @return bool
     */
    public function delete_cache($uid){
        Cache::tags(["sys_message:{$uid}"])->flush();
        return true;
    }

    /**
     * 获取当前消息是否已读
     *
     * @param int $uid 会员id
     * @param int $id 消息id
     * @return bool
     */
    public function get_read_status($uid, $id){
        return Redis::sismember('sys_message_read:' . $uid, $id);
    }

    /**
     * 将当前消息设置为已读
     *
     * @param int $uid 会员id
     * @param int $id 消息id
     * @return bool
     */
    public function set_read_status($uid, $id){
        return Redis::sadd('sys_message_read:' . $uid, $id);
    }
}