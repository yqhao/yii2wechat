<?php

namespace frontend\modules\api\v1\controllers;

use common\models\User;
use common\models\UserWechat;
use frontend\modules\api\v1\components\Wechat;
use frontend\modules\api\v1\filters\BearerAuth;
use frontend\modules\api\v1\resources\User as UserResource;
use yii\base\Exception;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class UserInfoController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\UserWechat';

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => BearerAuth::className(),
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [];
    }


    /**
     * 保存用户信息
     */
    public function actionSave(){
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $user_info = \Yii::$app->request->post('user_info',null);
            if(is_object($user_info)){
                $user_info = json_encode($user_info);
            }
//            return ['data'=>var_export($user_info,true)];
            if(!\Yii::$app->request->isPost || empty($user_info)){
                throw new Exception('请求错误');
            }


            $model = UserWechat::find(['openid'=>\Yii::$app->user->id])->one();
            if(empty($model)){
                throw new Exception('用户不存在');

            }
//            $model->user_info = $user_info;
            $model->setAttribute('user_info', $user_info);
            if(!$model->validate(['user_info']) || !$model->save()){

                throw new Exception(var_export($model->getErrors(),true));
            }
            $transaction->commit();


            return ['data'=>true];

        }catch (Exception $e){
            $transaction->rollBack();
            throw new HttpException(422,$e->getMessage());
        }


    }


    
}
