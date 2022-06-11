<?php
namespace App\Api\Controllers;

use App\Api\Controllers\BaseController;
use App\Models\Sys\SysAd;
use App\Models\Sys\SysBanner;
use App\Models\Sys\SysNotice;
use App\Models\User\Users;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class SysController extends BaseController{
    /**
     * banner图
     *
     * @return void
     */
    public function banner(){
        $banners = SysBanner::getall();
        $url_show = config('project.banner.url_show');
        if($url_show == false){
            foreach($banners as $key => $value){
                $banners[$key] = $value->image;
            }
        }
        return success('轮播图', $banners);
    }

    /**
     * 公告
     *
     * @return void
     */
    public function notice(Request $request){
        $sys_type = config('project.notice.type');
        $sys_image_show = config('project.notice.image_show');
        switch($sys_type){
            case '单条文字':
                $notice = SysNotice::getall()[0];
                $data = ['content'=> $notice->title];
                break;
            case "单条富文本":
                $notice = SysNotice::getall()[0];
                $data['title'] = $notice->title;
                $data['content'] = $notice->content;
                $sys_image_show ? $data['image'] = $notice->image : '';
                break;
            case "多条富文本":
                $id = $request->input('id', 0);
                if($id == 0){
                    $data = SysNotice::getall();
                    foreach($data as $key=> $value){
                        if($sys_image_show == false){
                            unset($data[$key]->image);
                        }
                        unset($data[$key]->content);
                    }
                }else{
                    $data = SysNotice::getone($id);
                    if($sys_image_show == false){
                        unset($data->image);
                    }
                }
                break;
            default:
                return error('公告项配置异常');
        }
        return success('公告', $data);
    }

    /**
     * 获取指定广告，如果是广告位则获取广告位下所有广告
     *
     * @param Request $request
     * @return void
     */
    public function ad(Request $request){
        $id = $request->input('id', 0);
        $data = SysAd::getone($id);
        if(empty($data['title'])){  // 是广告位，需要解析数据
            foreach($data as $key=> $value){
                $data[$key] = json_decode($value);
            }
        }
        return success('广告', $data);
    }
}
