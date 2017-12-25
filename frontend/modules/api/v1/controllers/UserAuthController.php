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
class UserAuthController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\UserWechat';

    /**
     * @return array
     */
//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//
//        $behaviors['authenticator'] = [
//            'class' => BearerAuth::className(),
////            'realm' => 'auth_key'
//        ];
//
//        return $behaviors;
//    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [];
    }


    /**
     * 微信登录
     */
    public function actionSendCode(){
        /*
         *
         * 1.code2session
         * 2.保存 code session
         * 3.生成 user
         * 4.生成 token
         * 5.返回 token
         *
         */
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $code = \Yii::$app->request->post('code',false);
            if(!\Yii::$app->request->isPost || !$code){
                throw new Exception('请求错误');
            }

            $sessionInfo = Wechat::code2session($code);
            if(empty($sessionInfo)){
                throw new Exception('请求code错误');
            }

            $model = UserWechat::find()->andWhere(['openid'=>$sessionInfo->openid])->one();

            if(empty($model)){
                $model = new UserWechat();
                $model->setScenario('code2session');
                $model->setIsNewRecord(true);
                $model->openid = $sessionInfo->openid;
                // insert user
                $password = \Yii::$app->getSecurity()->generateRandomString(8);
                $user = $model->signUp($password);
                $model->user_id = $user->id;
                $model->remark = $password;

            }elseif($model->status != UserWechat::STATUS_ACTIVE){
                throw new Exception('账号异常或被禁用');
            }
            $model->code = $code;
            $model->session_key = $sessionInfo->session_key;
            if(isset($sessionInfo->unionid)) $model->unionid = $sessionInfo->unionid;

            $model->refreshToken();
            $model->auth_key = \Yii::$app->getSecurity()->generateRandomString(32);
            $model->status = UserWechat::STATUS_ACTIVE;
            if(!$model->save()){
                throw new Exception($model->getErrors());
            }
            $transaction->commit();

            $data = [
                'auth_key' => $model->auth_key,
                'token' => $model->token,
                'user_id' => $model->user_id,
                'expire_at' => $model->expire_at,

            ];

            return ['data'=>$data];

        }catch (Exception $e){
            $transaction->rollBack();
            throw new HttpException(422,$e->getMessage());
        }


    }

    
    public function actionCheckLogin(){
        
        try{
            $token = \Yii::$app->request->post('token',false);
            if(!\Yii::$app->request->isPost || !$token){
                throw new Exception('请求错误');
            }

            $message = '';
            $user = UserWechat::findIdentityByAccessToken($token);
            if(empty($user)){
                $message = '登录无效,请重新登录';
                $this->response_status = 0;
                return ['message'=>$message,'data'=> null];
            }
            if(!$user->validateExpire()){
                $this->response_status = 0;
                $message = '登录超时,请重新登录';
                return ['message'=>$message,'data'=> null];
            }

            return ['data'=> true];

        }catch (Exception $e){
            throw new HttpException(422,$e->getMessage());
        }
        
        
        
        
    }

    
}
