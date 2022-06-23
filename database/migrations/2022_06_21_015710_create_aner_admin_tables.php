<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('article')) {
            Schema::create('article', function (Blueprint $table) {
                $table->increments('id');
                $table->string('tag_ids')->comment('标签');
                $table->integer('category_id')->comment('分类')->default('0');
                $table->string('title')->comment('标题')->default('');
                $table->string('author')->comment('作者')->default('');
                $table->string('intro', 2000)->comment('简介')->default('');
                $table->string('keyword', 500)->comment('关键字')->default('');
                $table->string('image')->comment('图片')->default('');
                $table->text('content')->comment('内容');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }

        if (!Schema::hasTable('article_category')) {
            Schema::create('article_category', function(Blueprint $table){
                $table->increments('id');
                $table->string('name')->comment('分类名称')->default('');
                $table->string('image')->comment('分类图片')->default('');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }

        if (!Schema::hasTable('article_tag')) {
            Schema::create('article_tag', function(Blueprint $table){
                $table->increments('id');
                $table->string('name')->comment('标签名称')->default('');
                $table->string('image')->comment('标签图片')->default('');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }

        if (!Schema::hasTable('log_sys_message')) {
            Schema::create('log_sys_message', function(Blueprint $table){
                $table->increments('id');
                $table->integer('uid')->comment('会员id')->default('0');
                $table->string('title')->comment('标题')->default('');
                $table->string('image')->comment('图片')->default('');
                $table->text('content')->comment('内容');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }

        if (!Schema::hasTable('log_user_fund')) {
            Schema::create('log_user_fund', function(Blueprint $table){
                $table->increments('id');
                $table->integer('uid')->comment('会员id')->default('0');
                $table->string('number')->comment('金额')->default('');
                $table->string('coin_type')->comment('币种')->default('');
                $table->string('fund_type')->comment('操作类型')->default('');
                $table->string('content')->comment('说明')->default('');
                $table->string('remark')->comment('备注')->default('');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('log_user_operation')) {
            Schema::create('log_user_operation', function(Blueprint $table){
                $table->increments('id');
                $table->integer('uid')->comment('会员id')->default('0');
                $table->string('content')->comment('操作内容')->default('');
                $table->string('remark')->comment('备注')->default('');
                $table->string('ip')->comment('ip')->default('');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('log_user_pay')) {
            Schema::create('log_user_pay', function(Blueprint $table){
                $table->increments('id');
                $table->integer('uid')->comment('会员id')->default('0');
                $table->string('order_no')->comment('支付单号')->default('');
                $table->string('type')->comment('支付方式')->default('');
                $table->string('order_type')->comment('订单类型')->default('');
                $table->decimal('money', $precision = 10, $scale = 2)->comment('充值金额')->default('0.00');
                $table->string('platform')->comment('来源端')->default('');
                $table->tinyInteger('status')->comment('订单状态{radio}(1:待支付,2:支付成功,3:订单取消)')->default('1');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('sys_ad')) {
            Schema::create('sys_ad', function(Blueprint $table){
                $table->increments('id');
                $table->integer('parent_id')->comment('广告位id')->default('0');
                $table->string('title')->comment('标题')->default('');
                $table->string('image')->comment('图片')->default('');
                $table->string('value')->comment('值')->default('');
                $table->text('content')->comment('内容');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }

        if (!Schema::hasTable('sys_banner')) {
            Schema::create('sys_banner', function(Blueprint $table){
                $table->increments('id');
                $table->string('image')->comment('图片')->default('');
                $table->string('url')->comment('链接')->default('');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }

        if (!Schema::hasTable('sys_notice')) {
            Schema::create('sys_notice', function(Blueprint $table){
                $table->increments('id');
                $table->string('title')->comment('标题')->default('');
                $table->string('image')->comment('图片')->default('');
                $table->text('content')->comment('内容');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }

        if (!Schema::hasTable('sys_setting')) {
            Schema::create('sys_setting', function(Blueprint $table){
                $table->increments('id');
                $table->integer('parent_id')->comment('广告位id')->default('0');
                $table->string('title')->comment('标题')->default('');
                $table->string('input_type')->comment('表单类型')->default('');
                $table->string('value')->comment('值')->default('');
                $table->string('remark')->comment('备注')->default('');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }

        if (!Schema::hasTable('user_detail')) {
            Schema::create('user_detail', function(Blueprint $table){
                $table->integer('id');
            });
        }

        if (!Schema::hasTable('user_funds')) {
            Schema::create('user_funds', function(Blueprint $table){
                $table->integer('id');
                $table->decimal('money', $precision = 10, $scale = 2)->comment('余额')->default('0.00');
            });
        }

        if (!Schema::hasTable('users')) {
            Schema::create('users', function(Blueprint $table){
                $table->increments('id');
                $table->string('avatar')->comment('头像')->default('');
                $table->string('account', 20)->comment('会员账号')->default('');
                $table->string('phone', 11)->comment('会员手机号')->default('');
                $table->string('email')->comment('会员邮箱')->default('');
                $table->string('nickname')->comment('会员昵称')->default('');
                $table->string('password', 32)->comment('会员登录密码')->default('');
                $table->string('level_password', 6)->comment('会员二级密码')->default('');
                $table->string('password_salt', 6)->comment('密码加盐')->default('');
                $table->integer('parent_id')->comment('上级会员id')->default('0');
                $table->tinyInteger('is_login')->comment('是否可以登录，1是0否')->default('1');
                $table->string('login_type')->comment('第三方登录方式')->default('');
                $table->string('unionid')->comment('第三方登录标识')->default('');
                $table->string('openid')->comment('单平台内唯一标识')->default('');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable()->default(null);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('article_tag');
        Schema::dropIfExists('log_sys_message');
        Schema::dropIfExists('log_user_fund');
        Schema::dropIfExists('log_user_operation');
        Schema::dropIfExists('log_user_pay');
        Schema::dropIfExists('sys_ad');
        Schema::dropIfExists('sys_banner');
        Schema::dropIfExists('sys_notice');
        Schema::dropIfExists('sys_setting');
        Schema::dropIfExists('user_detail');
        Schema::dropIfExists('user_funds');
        Schema::dropIfExists('users');
    }
};
