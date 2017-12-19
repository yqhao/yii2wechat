<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <p>
        <?php echo Html::a('< 返回', Yii::$app->request->referrer, ['class' => 'btn bg-purple']) ?>
        <?php //echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'code',
            [
                'label' => '微信用户',
                'attribute' => 'user_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $userWechat = $model->userWechat;
                    //return !empty($userWechat) ? $userWechat->nickname : null;

                    $string = null;
                    if(!empty($userWechat)){
                        if($userWechat->user_info){
                            $userInfo = \GuzzleHttp\json_decode($userWechat->user_info);
                            $string = '<table>';
                            $string .= '<tr><td width="80px;"><img style="width: 60px;height: 60px;" src="'.$userInfo->avatarUrl.'"></td><td width="120px;">'.$userInfo->nickName.'</td><td width="180px;">'.$userInfo->province.' / '.$userInfo->city.'</td></tr>';
                            $string .= '</table>';
                        }
                    }

                    return $string;
                }
            ],
            'package_title',
            [
                'label' => '门票',
                'attribute' => 'package_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $string = '';
                    if(!empty($model->orderItems)){
                        $string = '<table><tr><th width="260px">名称</th><th width="80px">单价</th><th width="80px">数量</th><th width="120px">使用日期</th></tr>';
                        foreach ($model->orderItems as $value){
                            $string .= '<tr><td>'.$value->package_item_title.'</td><td>'.$value->price.'</td><td>'.$value->quantity.'</td><td>'.$value->use_date.'</td></tr>';
                        }
                        $string .= '</table>';
                    }
                    return $string;
                }
            ],
            'contact_name',
            'contact_mobile',
            'remark:ntext',
            'user_id',
//            'package_id',
            'total_quantity',
            'total_price',
            'total_sale_price',
            'payment_price',
            'discount',
            'discount_info:ntext',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'payment_type',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\Order::paymentTypes($model->payment_type);
                }
            ],
            [
                'attribute' => 'payment_status',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\Order::paymentStatus($model->payment_status);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\Order::status($model->status);
                }
            ],
            'coupon_code',
            'after_sale_status',
        ],
    ]) ?>

</div>
