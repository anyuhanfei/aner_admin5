<?php
namespace App\Api\Service\Trigonal;


class YidunMobileService{
    private static $url = "https://ye.dun.163.com/v1/oneclick/check";
    private static $secretId = '665d6b42a3668dfc11a124f4764a7133';
    private static $businessId = '5f5569ca10db4c0e84a4a9ce871c3afb';
    private static $version = 'v1';
    private static $secretKey = 'f7e074675480f2a1fdb784d9b21a0b99';

    public static function oauth($token, $accessToken)
    {
        $params["token"] = $token;
        $params["accessToken"] = $accessToken;
        $params["secretId"] = self::$secretId;
        $params["businessId"] = self::$businessId;
        $params["version"] = self::$version;
        $params["timestamp"] = sprintf("%d", round(microtime(true) * 1000));
        $params["nonce"] = substr(md5(time()), 0, 32);
        $params = self::toUtf8($params);
        $params["signature"] = self::gen_signature(self::$secretKey, $params);
        $options = array('http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'timeout' => 5,
            'content' => http_build_query($params)
        ));
        $context = stream_context_create($options);
        $result = file_get_contents(self::$url, false, $context);
        if ($result === FALSE) {
            return array("code" => 500, "msg" => "file_get_contents failed.");
        } else {
            return json_decode($result, true);
        }
    }

    public static function gen_signature($secretKey, $params){
        ksort($params);
        $buff="";
        foreach($params as $key=>$value){
            $buff .=$key;
            $buff .=$value;
        }
        $buff .= $secretKey;
        return md5(mb_convert_encoding($buff, "utf8", "auto"));
    }

    /**
     * 将输入数据的编码统一转换成utf8
     * @params 输入的参数
     */
    public static function toUtf8($params){
        $utf8s = array();
        foreach ($params as $key => $value) {
            $utf8s[$key] = is_string($value) ? mb_convert_encoding($value, "utf8", 'auto') : $value;
        }
        return $utf8s;
    }
}