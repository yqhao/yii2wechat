<?php
namespace backend\components;
use Yii;
use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: HowardPC
 * Date: 2017/12/2
 * Time: 21:02
 */
class UrlHelper
{

    public static function getPreUrl(){
        $url = Yii::$app->request->referrer;
        if($url == null){
            $url = Url::to(['index']);
        }elseif(strpos($url,Url::to(['index'])) === false){
            $url = Url::to(['index']);
        }
//        var_dump(Yii::$app->request->referrer,$url);exit;
        return $url;
    }

}