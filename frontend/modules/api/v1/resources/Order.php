<?php

namespace frontend\modules\api\v1\resources;

use common\models\OrderItem;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;


class Order extends \common\models\Order implements Linkable
{
    public function fields()
    {

        return [
            'id',
            'code'=>function($model){
                return $model->payment_status == 1 ? $model->code : '';
            },
            'package_title', 'package_id','total_quantity', 'total_price', 'payment_price',
            'discount',
            'created_at'=>function($model){
                return $model->created_at> 1 ? date('Y-m-d H:i:s',$model->created_at) : '';
            },
            'payment_status',
            'payment_status_label'=>function($model){
                return $model->payment_status == 1 ? '已付款' : '未付款';
            },'coupon_code','contact_name','contact_mobile',
            'items'=>function($model){
                return OrderItem::find()->select('package_item_id,package_item_title,price,quantity,use_date')->andWhere(['order_id'=>$model->id])->all();
            }
        ];
    }

//    public function extraFields()
//    {
//        return ['orderItems','Coupon','Package'];
//    }
    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['order/view', 'id' => $this->id], true)
        ];
    }

}
