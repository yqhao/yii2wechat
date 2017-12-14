<?php

namespace common\models\query;

use common\models\Order;
use yii\db\ActiveQuery;

class OrderQuery extends ActiveQuery
{
    public function mySelf()
    {
        $this->andWhere(['user_id' => \Yii::$app->user->identity->getUserId()]);
        return $this;
    }

    public function filterParams($params)
    {
        $this->andWhere(['status' => Order::STATUS_CREATED]);
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
