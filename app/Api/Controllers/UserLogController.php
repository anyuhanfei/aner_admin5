<?php
namespace App\Api\Controllers;

use Illuminate\Support\Facades\DB;

use App\Api\Controllers\BaseController;
use App\Models\Log\LogSysMessage;
use App\Models\Log\LogUserFund;
use App\Models\Sys\SysSetting;
use App\Models\User\UserFunds;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class UserLogController extends BaseController{
    /**
     * 会员资产流水记录
     *
     * @param Request $request
     * @return void
     */
    public function fund_log(Request $request){
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 2);
        $data = Cache::tags("user_fund_log:{$this->uid}")->remember("user_fund_log:{$this->uid}:{$page}:{$limit}", 86400, function() use($page, $limit){
            return LogUserFund::where('uid', $this->uid)->select(['number', 'coin_type', 'fund_type', 'created_at'])->orderBy('id', 'desc')->simplePaginate($limit);
        });
        return success('资产流水日志', $data);
    }

    /**
     * 系统消息记录
     *
     * @param Request $request
     * @return void
     */
    public function sys_message_log(Request $request){
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $list_read = config('project.sys_message.list_read');
        $data = Cache::tags(["sys_message", "sys_message:{$this->uid}"])->remember("sys_message:{$this->uid}:{$page}:{$limit}", 86400, function() use($page, $limit){
            return LogSysMessage::whereIn('uid', [0, $this->uid])->select(['id', 'title', 'image', 'created_at'])->orderBy('id', 'desc')->simplePaginate($limit);
        });
        foreach ($data as &$value) {
            $value->is_read = LogSysMessage::get_read_status($this->uid, $value->id);
            if($list_read){
                LogSysMessage::set_read_status($this->uid, $value->id);
            }
        }
        return success('系统消息', $data);
    }

    /**
     * 获取系统消息的详情
     *
     * @param Request $request
     * @return void
     */
    public function sys_message_detail(Request $request){
        $id = $request->input('id', 0);
        $list_read = config('project.sys_message.list_read');
        $data = Cache::remember("sys_message_id:{$id}", 1, function() use($id){
            return LogSysMessage::whereIn('uid', [0, $this->uid])->where('id', $id)->select(['id', 'title', 'image', 'created_at'])->first();
        });
        $data->is_read = LogSysMessage::get_read_status($this->uid, $data->id);
        if($list_read == false){
            LogSysMessage::set_read_status($this->uid, $data->id);
        }
        return success('系统消息', $data);
    }
}
