<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use Dcat\Admin\Http\Controllers\AdminController;

class BaseController extends AdminController{
    public function __construct(){
        $this->sys = [
            # 富文本图片上传规则
            "upload_disk"=> "admin",
            # 会员
            "users"=> [
                // 会员标识字段：phone, email, account
                "user_identity"=> ['phone'],
                // 头像、昵称字段是否展示
                "avatar_show"=> true,
                "nickname_show"=> true,
                "laval_password_show"=> true,
                "parent_show"=> true,
                // 会员资产  字段=> 字段注释
                "user_funds"=> [
                    'money'=> '余额',
                ],
                // 会员操作类型
                "fund_type"=> [
                    '充值'=> '充值',
                ]
            ],
            # 文章
            "article"=> [
                'category_image_show'=> false,
                'tag_image_show'=> false,
                'tag_show'=> true,
                'author_show'=> true,
                'intro_show'=> true,
                'keyword_show'=> true,
                'image_show'=> true
            ],
            # banner图
            'banner'=> [
                'url_show'=> true,
            ],
            # 系统设置
            'setting'=> [
                // 行内工具栏是否展示
                'line_button_show'=> true,
            ],
            # 公告
            "notice"=> [
                // 图片字段是否展示
                'image_show'=> true,
                // 类型：单条文字, 单条富文本, 多条富文本
                'type'=> '多条富文本'
            ],
            # 系统消息
            "sys_message"=> [
                'image_show'=> false,
                'content_show'=> false,
            ],
        ];
    }
}
