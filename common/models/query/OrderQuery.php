<?php

namespace common\models\query;

use common\models\Order;
use yii\db\ActiveQuery;

class OrderQuery extends ActiveQuery
{
//    public function payed()
//    {
//        $this->andWhere(['payment_status' => Order::PAYMENT_STATUS_NO]);
//        return $this;
//    }
//    public function unPayed()
//    {
//        $this->andWhere(['payment_status' => Order::PAYMENT_STATUS_YES]);
//        return $this;
//    }
    public function filterParams($params){
        if(isset($params['code']) && $params['code']){
            $this->andWhere(['code' => (int)$params['code']]);
        }
        if(isset($params['status']) && $params['status'] !==null && $params['status'] !== ''){
            $this->andWhere(['status' => (int)$params['status']]);
        }
        if(isset($params['payment_status']) && $params['payment_status'] !==null && $params['payment_status'] !== ''){
            $this->andWhere(['payment_status' => (int)$params['payment_status']]);
        }
        $this->orderBy(['id' => SORT_DESC]);
        return $this;
    }
}
