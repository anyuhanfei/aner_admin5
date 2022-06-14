<?php
namespace App\Api\Controllers;

use App\Api\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Api\Service\SysService;
class SysController extends BaseController{
    public function __construct(Request $request){
        parent::__construct($request);
        $this->sys_service = new SysService();
    }

    /**
     * banner图
     *
     * @return void
     */
    public function banner(){
        return success('轮播图', $this->sys_service->get_banners());
    }

    /**
     * 公告
     *
     * @param Request $request
     * @return void
     */
    public function notice(Request $request){
        $id = $request->input('id', 0);
        return success('公告', $this->sys_service->get_notice($id));
    }

    /**
     * 获取指定广告，如果是广告位则获取广告位下所有广告
     *
     * @param Request $request
     * @return void
     */
    public function ad(Request $request){
        $id = $request->input('id', 0);
        return success('广告', $this->sys_service->get_ad($id));
    }
}
