<?php
namespace frontend\modules\api\v1\controllers;

use common\models\OrderItem;
use frontend\modules\api\v1\models\OrderForm;
use frontend\modules\api\v1\resources\Order;

use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class OrderController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class OrderController extends ApiController
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\Order';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'create' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
//                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => 'create',
            ],
        ];

    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $params = \Yii::$app->request->queryParams;
        return new ActiveDataProvider(array(
            'query' => Order::find()->filterParams($params),
            //'pagination' => ['pageSize' => '2']
        ));
    }


    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = Order::find()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return ["data"=>$model];
    }

    public function actionAdd(){
        $post = \Yii::$app->getRequest()->getBodyParams();
        if(empty($post)){
            throw new HttpException(422,'缺少参数');
//            \Yii::$app->response->setStatusCode(422);
//            return ["status"=>0,"message"=>'缺少参数',"request"=>\Yii::$app->getRequest()];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new OrderForm();
            $model->setScenario('create');
            
            if (!$model->load($post, '') || !$model->save()) {
                return $model;
            }

            $transaction->commit();

            return ["data"=>$model];
        } catch (Exception $e) {
            throw new HttpException(422,$e->getMessage());
//            return ["status"=>0,"message"=>$e->getMessage(),'trace'=>$e->getTraceAsString()];
        }
    }
}
