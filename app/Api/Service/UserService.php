<?php
namespace App\Api\Service;

use App\Api\Repositories\User\UsersRepositories;
use Illuminate\Support\Facades\Http;

class UserService{
    protected $repositories;

    public function __construct(){
        $this->repositories = new UsersRepositories();
    }

    /**
     * 修改会员数据
     *
     * @param int $uid 会员id
     * @param array $field_values 字段和值组成键值对的数组
     * @return void
     */
    public function update_data($uid, $field_values){
        $data = [];
        foreach($field_values as $field=> $value){
            switch($field){
                case "password":
                    [$data['password'], $data['password_salt']] = $this->repositories->set_password($value);
                    break;
                default:
                    $data[$field] = $value;
                    break;
            }
        }
        return $this->repositories->update_data($uid, $data);
    }

    /**
     * 登录操作，获取会员信息并设置token
     *
     * @param string $field 会员标识
     * @param string $value 值
     * @param string $type 登录类型，其中 password类型不能在登录时注册
     * @return void
     */
    public function login($field, $value, $type = 'password', $create_data = []){
        $user = $this->repositories->get_data($field, $value);
        $data = [
            'uid'=> $user->id,
            'avatar'=> $user->avatar,
            'phone'=> $user->phone,
            'avatar'=> $user->avatar,
        ];
        if(in_array($type, ['password'])){
            $data['is_register'] = 0;
            if(!$user){  // 注册
                $user = $this->repositories->create_data($value, '', 0, $create_data);
                $data['is_register'] = 1;
            }
        }
        $data['token'] = $this->repositories->set_token($user->id);
        return $data;
    }

    /**
     * 微信小程序登录
     *
     * @param string $code
     * @return void
     */
    public function wxmini_login($code){
        $sys_setting_repositories = new \App\Api\Repositories\Sys\SysSettingRepositories();
        $appid = $sys_setting_repositories->get(16);
        $secret = $sys_setting_repositories->get(17);
        $api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
        $res = json_decode(Http::get($api), true);
        if($res['errcode'] == 0){
            return $this->login('openid', $res['openid'], 'third_party', [
                'openid' => $res['openid'],
                'unionid' => $res['unionid'] ?? '',
            ]);
        }else{
            return ['errmsg'=> $res['errmsg']];
        }
    }

    /**
     * 通过token获取到会员id
     *
     * @param string $token token
     * @return void
     */
    public function use_token_get_uid($token){
        return $this->repositories->use_token_get_uid($token);
    }

    /**
     * 通过会员id获取到会员对象
     *
     * @param int $uid 会员id
     * @return void
     */
    public function use_id_get_data($uid){
        return $this->repositories->get_data('id', $uid);
    }

    //获取unionID
    private function decryptData($appid, $sessionKey, $encryptedData, $iv){
        $IllegalAesKey = -41001;
        $IllegalIv = -41002;
        $IllegalBuffer = -41003;
        $DecodeBase64Error = -41004;
        if(strlen($sessionKey) != 24){
            return $IllegalAesKey;
        }
        $aesKey = base64_decode(str_replace(" ", "+", $sessionKey));
        if(strlen($iv) != 24){
            return $IllegalIv;
        }
        $aesIV = base64_decode(str_replace(" ", "+", $iv));
        $aesCipher = base64_decode(str_replace(" ", "+", $encryptedData));
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj = json_decode($result);
        if($dataObj == NULL){
            return $IllegalBuffer;
        }
        if($dataObj->watermark->appid != $appid){
            return $DecodeBase64Error;
        }
        $data = json_decode($result, true);
        return $data;
    }

    private function define_str_replace($data){
        return str_replace(' ', '+', $data);
    }
}