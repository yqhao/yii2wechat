<?php

namespace backend\controllers;

use common\models\Order;
use Yii;
use backend\models\search\TimelineEventSearch;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Application timeline controller
 */
class TimelineEventController extends Controller
{
    public $layout = 'common';
    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];
        $startTime = time()-86400*6;
        $endTime = time();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'orderCounts' => $this->getOrderCount($startTime,$endTime),
            'memberCounts' => $this->getMemberCount($startTime,$endTime)
        ]);
    }

    protected function getOrderCount($startTime,$endTime){
        $cacheKey = 'get-order-counts-'.$startTime.'-'.$endTime;
        $cacheData = \Yii::$app->getCache()->get($cacheKey);
        if(!empty($cacheData)){
            var_dump($cacheData);exit;
            return $cacheData;
        }
        $data = [];
        $payData = [];
        $map = [];
        $startDay = date('Ymd',$startTime);
        $endDay = date('Ymd',$endTime);

        $orderCounts = \Yii::$app->db->createCommand("SELECT count(id) as counts, FROM_UNIXTIME(created_at, '%Y%m%d') AS create_day
FROM `order` WHERE created_at BETWEEN :start AND :end GROUP BY create_day;")
            ->bindValues([':start'=>$startTime,':end'=>$endTime])->queryAll();
        if(!empty($orderCounts))$map = ArrayHelper::map($orderCounts,'create_day','counts');
        for($i=$startDay;$i<=$endDay;$i++){
            $data[$i] = isset($map[$i]) ? $map[$i] : 0;
        }
        $day = array_keys($data);

        $payCounts = \Yii::$app->db->createCommand("SELECT count(id) as counts, FROM_UNIXTIME(created_at, '%Y%m%d') AS create_day
FROM `order` WHERE payment_status=:pay AND created_at BETWEEN :start AND :end GROUP BY create_day;")
            ->bindValues([':pay'=>Order::PAYMENT_STATUS_YES,':start'=>$startTime,':end'=>$endTime])->queryAll();
        if(!empty($payCounts))$payCountsMap = ArrayHelper::map($payCounts,'create_day','counts');
        for($i=$startDay;$i<=$endDay;$i++){
            $payData[$i] = isset($payCountsMap[$i]) ? $payCountsMap[$i] : 0;
        }


        $result =  json_encode(['day' => $day, 'totalCount' => $data, 'payCount' => $payData]);
        \Yii::$app->getCache()->set($cacheKey,$result,3600);
        return $result;
    }

    protected function getMemberCount($startTime,$endTime){
        $cacheKey = 'get-member-counts-'.$startTime.'-'.$endTime;
        $cacheData = \Yii::$app->cache->get($cacheKey);
        if(!empty($cacheData)){
            return $cacheData;
        }
        $data = [];
        $map = [];

        $startDay = date('Ymd',$startTime);
        $endDay = date('Ymd',$endTime);

        $counts = \Yii::$app->db->createCommand("SELECT count(1) as counts, FROM_UNIXTIME(created_at, '%Y%m%d') AS create_day
FROM `user_wechat` WHERE created_at BETWEEN :start AND :end GROUP BY create_day;")
            ->bindValues([':start'=>$startTime,':end'=>$endTime])->queryAll();
        if(!empty($counts))$map = ArrayHelper::map($counts,'create_day','counts');
        for($i=$startDay;$i<=$endDay;$i++){
            $data[$i] = isset($map[$i]) ? $map[$i] : 0;
        }
        $day = array_keys($data);
        $result = json_encode(['day' => $day, 'count' => $data]);
        \Yii::$app->cache->set($cacheKey,$result,3600);
        return $result;
    }
}
