<?php

namespace App\Api\Middleware;

use App\Api\Repositories\User\UsersRepositories;
use Closure;

class UserTokenVerify{

    /**
     * 判断header中是否传token以验证用户是否登录
     *
     * @param [type] $request
     * @param Closure $next
     * @return void
     */
    public function handle($request, Closure $next){
        if(!$request->hasHeader('token')){
            return error('请先登录');
        }
        $UsersRepositories = new UsersRepositories();
        $uid = $UsersRepositories->use_token_get_uid($request->header('token'));
        if($uid == 0){
            return error('请先登录');
        }
        $request->merge(['uid' => $uid]);
        return $next($request);
    }
}
