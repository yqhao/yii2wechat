<?php

namespace frontend\modules\api\v1\components;


use yii\base\Exception;
/**
 * 微信api
 * @property string $openid
 * @property string $session_key
 * @property string $unionid
 */
class Wechat
{

    const APP_ID = 'wxe7d29a3294587759';
    const SECRET = '683bf57910ebbe8e32cc6dbf7472624e';
    /**
     * 获取微信服务器session
     * @param $code 登录时获取的 code
     * @return Wechat
     *          openid 	用户唯一标识
     *          session_key 	会话密钥
     *          unionid 	用户在开放平台的唯一标识符
     * @throws Exception
     *
     * 微信code2session接口
     * https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code
     * appid 	 	小程序唯一标识
     * secret 	 	小程序的 app secret
     * js_code 	    登录时获取的 code
     * grant_type 	填写为 authorization_code
     */
    public static function code2session($code){
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.self::APP_ID.'&secret='.self::SECRET.'&js_code='.$code.'&grant_type=authorization_code';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception("cURL Error #:" . $err);
        }
        if(!$response){
            throw new Exception("response is none");
        }
        $response = \GuzzleHttp\json_decode($response);
        if(isset($response->errcode)){
            throw new Exception($response->errmsg);
        }
        return $response;

    }
}