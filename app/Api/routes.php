<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::post('send/sms', '\App\Api\Controllers\BaseController@send_sms');

Route::post('login/password', '\App\Api\Controllers\LoginController@password_login');
Route::post('login/sms', '\App\Api\Controllers\LoginController@sms_login');
Route::post('login/oauth', '\App\Api\Controllers\LoginController@oauth_login');
Route::post('login/third_party', '\App\Api\Controllers\LoginController@third_party_login');
Route::post('register', '\App\Api\Controllers\LoginController@register');

Route::post('sys/banner', '\App\Api\Controllers\SysController@banner');
Route::post('sys/notice', '\App\Api\Controllers\SysController@notice');
Route::post('sys/ad', '\App\Api\Controllers\SysController@ad');

Route::group([
    'middleware' => ['user.token'],
], function(Router $router){
    $router->post('user/detail', '\App\Api\Controllers\UserController@detail');
    $router->post('user/test', '\App\Api\Controllers\UserController@test');
    $router->post('user/log/fund', '\App\Api\Controllers\UserLogController@fund_log');
    $router->post('user/log/sysmessage', '\App\Api\Controllers\UserLogController@sys_message_log');
    $router->post('user/log/sysmessage/detail', '\App\Api\Controllers\UserLogController@sys_message_detail');
});

