<?php

namespace backend\controllers;

use backend\models\Weibo;
use Yii;
use common\models\Machine;
use backend\models\search\MachineSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class WeiboController extends Controller
{

    public function actionIndex(){

//        $this->loadPage("https://m.weibo.cn/status/4156923274428085?wm=3333_2001&from=1076093010&sourcetype=weixin","D:");
        $model = new Weibo();

        $model->loadPage("https://m.weibo.cn/status/4156697981655678","D:");

        exit;
    }
    
}
