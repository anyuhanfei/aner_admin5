<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception{
    /**
     * 业务异常构造函数
     * @param string $message 自定义返回信息
     */
    public function __construct($message){
        parent::__construct($message, 200);
    }
}
