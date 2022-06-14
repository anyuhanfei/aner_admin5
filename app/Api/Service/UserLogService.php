<?php
namespace App\Api\Service;

use App\Api\Repositories\Log\LogUserFundRepositories;
use App\Api\Repositories\Log\LogSysMessageRepositories;

class UserLogService{
    protected $log_user_fund_repositories;
    protected $log_sys_message_repositories;

    public function __construct(){
        $this->log_user_fund_repositories = new LogUserFundRepositories();
        $this->log_sys_message_repositories = new LogSysMessageRepositories();
    }

    public function fund_log($uid, $page, $limit = 10){
        return $this->log_user_fund_repositories->get_list($uid, $page, $limit);
    }

    public function sys_message_log($uid, $page, $limit = 10){
        $list_read = config('project.sys_message.list_read');
        $data = $this->log_sys_message_repositories->get_list($uid, $page, $limit);
        foreach($data as &$value){
            $value->is_read = $this->log_sys_message_repositories->get_read_status($uid, $value->id);
            if($list_read){
                $this->log_sys_message_repositories->set_read_status($uid, $value->id);
            }
        }
        return $data;
    }

    public function sys_message_detail($uid, $id){
        $data = $this->log_sys_message_repositories->get_one($uid, $id);
        $this->log_sys_message_repositories->set_read_status($uid, $data->id);  # 设置为已读（无论设置如何，这里必须设置已读）
        return $data;
    }
}