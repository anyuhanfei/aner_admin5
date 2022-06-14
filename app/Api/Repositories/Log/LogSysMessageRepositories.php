<?php
namespace App\Api\Repositories\Log;

use App\Models\Log\LogSysMessage as Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class LogSysMessageRepositories{
    protected $eloquentClass = Model::class;
    protected $cache_prefix = 'sys_message';

    public function get_list($uid, $page, $limit){
        return Cache::tags([$this->cache_prefix, "{$this->cache_prefix}:{$uid}"])->remember("{$this->cache_prefix}:{$uid}:{$page}:{$limit}", 86400, function() use($limit){
            $select = ['id', 'title', 'image', 'created_at'];
            return $this->eloquentClass::whereIn('uid', [0, $this->uid])->select($select)->orderBy('id', 'desc')->simplePaginate($limit);
        });
    }

    public function get_one($uid, $id){
        return Cache::remember("sys_message_id:{$id}", 86400, function() use($uid, $id){
            $select = ['id', 'title', 'image', 'created_at'];
            return $this->eloquentClass::whereIn('uid', [0, $uid])->where('id', $id)->select($select)->first();
        });
    }

    public function delete_cache($uid){
        Cache::tags(["{$this->cache_prefix}:{$uid}"])->flush();
        return true;
    }

    public function get_read_status($uid, $id){
        return Redis::sismember('sys_message_read:' . $uid, $id);
    }

    public function set_read_status($uid, $id){
        return Redis::sadd('sys_message_read:' . $uid, $id);
    }
}