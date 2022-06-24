<?php

function error($msg, $data = []){
    return return_data(500, $msg, $data);
}

function success($msg, $data = []){
    return return_data(200, $msg, $data);
}

function throwBusinessException($msg){
    throw new \App\Exceptions\BusinessException($msg);
}

function return_data($code, $msg, $data){
    return response()->json(['code'=> $code, 'msg'=> $msg, 'data'=> $data], 200);
}

/**
 * 生成随机码
 *
 * @param [type] $number 随机码位数
 * @param string $type 随机码内容类型
 * @return void
 */
function create_captcha($number, $type = 'figure'){
    $array_figure = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 0];
    $array_lowercase = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
    $array_uppercase = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    switch($type){
        case 'lowercase':
            $res_array = $array_lowercase;
            break;
        case 'uppercase':
            $res_array = $array_uppercase;
            break;
        case 'lowercase+figure':
            $res_array = array_merge($array_lowercase, $array_figure);
            break;
        case 'uppercase+figure':
            $res_array = array_merge($array_uppercase, $array_figure);
            break;
        case 'lowercase+uppercase':
            $res_array = array_merge($array_lowercase, $array_uppercase);
            break;
        case 'lowercase+uppercase+figure':
            $res_array = array_merge(array_merge($array_lowercase, $array_uppercase), $array_figure);
            break;
        default:
            $res_array = $array_figure;
            break;
    }
    $resstr = '';
    shuffle($res_array);
    foreach(array_rand($res_array, $number) as $v){
        $resstr .= $res_array[$v];
    }
    return $resstr;
}

function https_request($url,$data=null){
    //初始化curl
    $curl = curl_init();
    //curlopt_url
    curl_setopt($curl,CURLOPT_URL,$url);
    //curlopt_ssl_verifypeer禁止 CURL 验证对等证书
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
    //curlopt_ssl_verifyhost禁止验证host
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
    //验证$data
    if(!empty($data)){
        //curlopt_post
        curl_setopt($curl,CURLOPT_POST,1);
        //curl_postfieleds
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
    }
    //curlopt_returntransfer
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    //Content-Type: application/json 修改
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Content-Length: ' . strlen($data)
    ));
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}