<?php

namespace frontend\modules\api\v1\controllers;

use common\models\User;
use frontend\modules\api\v1\resources\User as UserResource;
use frontend\weixin\WxPayNotify;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\log\Logger;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class PaymentNotifyController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'common\models\PaymentNotify';

//    public $serializer = 'yii\rest\Serializer';
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass
            ]
        ];
    }

    /**
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = UserResource::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }
        return $model;
    }
    
    public function actionReceive(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        \Yii::getLogger()->log(var_export(file_get_contents('php://input'),true),Logger::LEVEL_ERROR);
        try{
            try{
                $notify = new WxPayNotify();
                $notify->Handle();
            }catch (Exception $e){
		\Yii::getLogger()->log($e->getMessage().PHP_EOL.$e->getTraceAsString(),Logger::LEVEL_ERROR);
                return [
                    'return_code' => 'FAIL',
                    'return_msg' => $e->getMessage(),
                ];
            }
        }catch (ErrorException $e){
	\Yii::getLogger()->log($e->getMessage().PHP_EOL.$e->getTraceAsString(),Logger::LEVEL_ERROR);
            return [
                'return_code' => 'FAIL',
                'return_msg' => $e->getMessage(),
            ];
        }
        
    }
}
