<?php
namespace App\Api\Service;

use App\Api\Repositories\Sys\SysBannerRepositories;
use App\Api\Repositories\Sys\SysNoticeRepositories;
use App\Api\Repositories\Sys\SysAdRepositories;

class SysService{
    protected $sys_banner_repositories;
    protected $sys_notice_repositories;
    protected $sys_ad_repositories;

    public function __construct(){
        $this->sys_banner_repositories = new SysBannerRepositories();
        $this->sys_notice_repositories = new SysNoticeRepositories();
        $this->sys_ad_repositories = new SysAdRepositories();
    }

    /**
     * 获取全部的轮播图
     *
     * @return void
     */
    public function get_banners(){
        $banners = $this->sys_banner_repositories->get_all();
        $url_show = config('admin.banner.url_show');
        if($url_show == false){
            foreach($banners as $key => $value){
                $banners[$key] = $value->image;
            }
        }
        return $banners;
    }

    /**
     * 获取公告
     * 根据系统设置返回指定公共
     *
     * @param integer $id
     * @return void
     */
    public function get_notice($id = 0){
        $sys_type = config('admin.notice.type');
        $sys_image_show = config('admin.notice.image_show');
        switch($sys_type){
            case '单条文字':
                $notice = $this->sys_notice_repositories->getall()[0];
                $data = ['content'=> $notice->title];
                break;
            case "单条富文本":
                $notice = $this->sys_notice_repositories->getall()[0];
                $data['title'] = $notice->title;
                $data['content'] = $notice->content;
                $sys_image_show ? $data['image'] = $notice->image : '';
                break;
            case "多条富文本":
                if($id == 0){
                    $data = $this->sys_notice_repositories->getall();
                    foreach($data as $key=> $value){
                        if($sys_image_show == false){
                            unset($data[$key]->image);
                        }
                        unset($data[$key]->content);
                    }
                }else{
                    $data = $this->sys_notice_repositories->getone($id);
                    if($sys_image_show == false){
                        unset($data->image);
                    }
                }
                break;
            default:
                return [];
        }
        return $data;
    }

    /**
     * 返回指定广告位信息
     *
     * @param [type] $id
     * @return void
     */
    public function get_ad($id){
        $data = $this->sys_ad_repositories->getone($id);
        if(empty($data['title'])){  // 是广告位，需要解析数据
            foreach($data as $key=> $value){
                $data[$key] = json_decode($value);
            }
        }
        return $data;
    }
}