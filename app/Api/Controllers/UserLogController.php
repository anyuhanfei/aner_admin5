<?php
namespace App\Api\Controllers;

use Illuminate\Support\Facades\DB;

use App\Api\Controllers\BaseController;
use App\Models\Log\LogSysMessage;
use App\Models\Log\LogUserFund;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Api\Service\UserLogService;

class UserLogController extends BaseController{
    public function __construct(Request $request, UserLogService $user_log_service){
        parent::__construct($request);
        $this->service = $user_log_service;
    }

    /**
     * 会员资产流水记录
     *
     * @param int $page 页码
     * @param int $limit 每页条数
     * @return void
     */
    public function fund_log(Request $request){
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 2);
        return success('资产流水日志', $this->service->fund_log($this->uid, $page, $limit));
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
        return success('系统消息', $this->service->sys_message_log($this->uid, $page, $limit));
    }

    /**
     * 获取系统消息的详情
     *
     * @param Request $request
     * @return void
     */
    public function sys_message_detail(Request $request){
        $id = $request->input('id', 0);
        return success('系统消息', $this->service->sys_message_log($this->uid, $id));
    }
}
