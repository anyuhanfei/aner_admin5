<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('users', 'UserController');
    $router->resource('article/category', 'Article\ArticleCategoryController');
    $router->resource('article/tag', 'Article\ArticleTagController');
    $router->resource('article', 'Article\ArticleController');

    $router->resource('sys/notice', 'Sys\SysNoticeController');
    $router->resource('sys/banner', 'Sys\SysBannerController');
    $router->resource('sys/ad', 'Sys\SysAdController');
    $router->resource('sys/setting', 'Sys\SysSettingController');
    $router->resource('sys/setting/tab', 'Sys\SysSettingController@tab');

    $router->resource('log/userfund', 'Log\LogUserFundController');
    $router->resource('log/sysmessage', 'Log\LogSysMessageController');

});
