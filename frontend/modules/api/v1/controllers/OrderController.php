<?php
namespace frontend\modules\api\v1\controllers;

use common\commands\AddToTimelineCommand;
use common\models\Coupon;
use common\models\OrderItem;
use common\models\Package;
use common\models\PackageItem;
use frontend\modules\api\v1\filters\BearerAuth;
use frontend\modules\api\v1\models\OrderForm;
use frontend\modules\api\v1\resources\Order;

use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
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
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => BearerAuth::className(),
//            'realm' => 'auth_key'
        ];

        return $behaviors;
    }
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
            'query' => Order::find()->mySelf()->filterParams($params),
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
            ->mySelf()
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
            $transaction->rollBack();
            throw new HttpException(422,$e->getMessage());
//            return ["status"=>0,"message"=>$e->getMessage(),'trace'=>$e->getTraceAsString()];
        }
    }

    public function actionCheckCoupon(){
        $post = \Yii::$app->getRequest()->getBodyParams();

        if(!\Yii::$app->getRequest()->isPost || empty($post)){
            throw new HttpException(422,'访问方式错误');
        }
//        $coupon = Coupon::findOne(['code'=>$post['code']]);

//        if(empty($coupon)){
//            throw new HttpException(422,'此优惠码不存在');
//        }
//        if($coupon['is_used']){
//            throw new HttpException(422,'此优惠码已被使用');
//        }
//        if($coupon['expiration_date'] > date('Y-m-d')){
//            throw new HttpException(422,'此优惠码已失效');
//        }

        try{
            $coupon = Coupon::findOne(['code'=>$post['code']]);

            if(empty($coupon)){
                throw new Exception('此优惠码不存在');
            }
            $coupon->getValidCoupon();
            $coupon->getValidOrder($post['total_price'],$post['total_quantity']);
        }catch (Exception $e){
            throw new HttpException(422,$e->getMessage());
        }




        return ["data"=>[
            "code"=>$coupon['code'],
            "title"=>$coupon['title'],
            "amount"=>$coupon['amount'],
            "type"=>$coupon['type']
        ]];
    }

    public function actionPay(){
        $post = \Yii::$app->getRequest()->getBodyParams();

        if(!\Yii::$app->getRequest()->isPost || empty($post)){
            throw new HttpException(422,'访问方式错误');
        }
        try{
            $order = Order::findOne(['id'=>$post['id'],'user_id'=>\Yii::$app->user->identity->getUserId()]);
            if(empty($order)){
                throw new Exception('此订单不存在');
            }
            if($order->payment_status == Order::PAYMENT_STATUS_YES){
                throw new Exception('此订单已支付,请不要重复支付!');
            }
//            $orderItems = $order->getOrderItems()->all();
            $orderItems = OrderItem::find()
                ->andWhere(['order_id'=>(int) $post['id']])
                ->select('package_id,package_item_id,package_item_title,price,quantity,use_date')->all();
            if(empty($orderItems)){
                throw new Exception('此订单数据异常!');
            }
            foreach ($orderItems as $value){
                if($value['use_date'] < date('Y-m-d')){
                    throw new Exception('订单超期不能支付!');
                }
            }
            // 优惠券抵消金额
            if($order->coupon_code){
                $coupon = Coupon::find()->andWhere(['order_id'=>(int) $post['id']])
                    ->select('code')->scalar();
                if(!empty($coupon) && $order->payment_price == 0){
                    $order->payment_type = \common\models\Order::PAYMENT_TYPE_DEFAULT;
                    $order->payment_status = \common\models\Order::PAYMENT_STATUS_YES;
                    if($order->save()){
                        Yii::$app->commandBus->handle(new AddToTimelineCommand([
                            'category' => 'order',
                            'event' => 'pay',
                            'data' => [
                                'order_id' => $order->id,
                                'package_title' => $order->package_title,
                                'created_at' => $order->created_at
                            ]
                        ]));
                        return ['data'=>true];
                    }
                }

            }

//            return ['data'=>false];
            throw new Exception('支付失败,暂未开通在线支付功能');

        }catch (Exception $e){
            throw new HttpException(422,$e->getMessage());
        }
    }

    public function actionDetail($id){

        $model = Order::find()
            ->mySelf()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }

//        $orderItems = OrderItem::find()
//            ->andWhere(['order_id'=>(int) $id])
//            ->select('package_id,package_item_id,package_item_title,price,quantity,use_date')->one();
        $coupon = Coupon::find()->andWhere(['order_id'=>(int) $id])
            ->select('code,title,type,amount')->one();

        $cover = Package::find()->andWhere(['id'=>$model->package_id])->select('cover,base_url')->one();
//        $order = $model->toArray();
//        $order['payment_status_label'] = $model->payment_status == 1 ? '已支付' : '未支付';
//        $order['created_at'] = date('Y-m-d H:i:s',$model->created_at) ;
        return ["data"=>['cover'=>$cover->getCover(),'order'=>$model,
//            'item'=>$orderItems,
            'coupon'=>$coupon]];
    }

    public function actionCancel(){

        try{
            if(!\Yii::$app->getRequest()->isPost){
                throw new Exception('访问方式错误');
            }
//            throw new Exception('订单不存在');
            $id = \Yii::$app->getRequest()->post('id');
            $model = Order::findOne(['id' => (int) $id,'user_id'=>\Yii::$app->user->identity->getUserId()]);
            if (!$model) {
                throw new Exception('订单不存在');
            }
            $model->status = \common\models\Order::STATUS_CANCEL;
            if(!$model->save()){
                throw new Exception('操作失败');
            }
            return ['data'=>true];

        }catch (Exception $e){
            throw new HttpException(422,$e->getMessage());
        }
    }
    


    public function actionGetDate(){

        try{

            $pid = \Yii::$app->getRequest()->get('id');
            $selectDate = \Yii::$app->getRequest()->get('selectDate',date("Y-m-d"));
            $page = \Yii::$app->getRequest()->get('page',1);

            //return ['date'=>[$selectDate]];
            if(!$pid){
                throw new Exception('数据不存在');
            }
            $item = PackageItem::findOne(['id'=>$pid]);
            if(empty($item)){
                throw new Exception('数据不存在');
            }
            $price = $item->price;
            $weekendPrice = PackageItem::getPriceByFormula($price,$item->price_rise_at_weekend);
            $holidayPrice = PackageItem::getPriceByFormula($price,$item->price_rise_at_holiday);


            $todayTime = strtotime(date("Y-m-d"));
            $selectTime = strtotime($selectDate);

            $firstDay = $page == 1 ? date('Y-m-01') : date('Y-m-01',strtotime('+1 month'));
            $firstDayTime = strtotime($firstDay);
            $firstDayDateInfo = getdate($firstDayTime);

            $startTime = $firstDayTime;

            if($firstDayDateInfo['wday']>0){
                $startTime = $firstDayTime - ($firstDayDateInfo['wday']*24*3600);
            }

            $calendar = [];
            $runTime = $startTime;
            for($i=1;$i<=42;$i++){
                $dateInfo = getdate($runTime);
                $calendar[$i] = [
                    'y' => $dateInfo['year'],//year
                    'm' => $dateInfo['mon'],//month
                    'w' => $dateInfo['wday'],//weekDay
                    'd'=> $dateInfo['mday'],//day
                    't'=> $dateInfo[0] == $selectTime ? 'select' : '',//isToday
                    'a' => $dateInfo[0] >= $todayTime ? '' : 'not',//isAllowed
                    'p' => in_array($dateInfo['wday'],[0,6]) ? $weekendPrice : $price//price
                ];
                $runTime += 24*3600;
            }


            return ['data'=>[
                'lastPage'=> $page > 1 ? '1' : '0',
                'nextPage'=> $page > 1 ? '0' : '1',
                'title'=>$firstDayDateInfo['year'].$firstDayDateInfo['mon'],
                'calendar'=>$calendar
            ]];
        }catch (Exception $e){
            throw new HttpException(422,$e->getMessage());
        }
    }
}
