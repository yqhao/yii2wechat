<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?php //echo Html::a(Yii::t('backend', 'Create {modelClass}', [
//    'modelClass' => 'Order',
//]), ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            [
                'label' => '微信用户',
                'attribute' => 'user_id',
                'format' => 'raw',
                'value' => function ($model) {
                    $userWechat = $model->userWechat;
                    return !empty($userWechat) ? $userWechat->nickname : null;
                }
            ],
            [
                'attribute' => 'package_title',
                'headerOptions' => ['width' => '180px'],
            ],
            [
                'label' => '门票',
                'attribute' => 'package_id',
                'format' => 'raw',
                'headerOptions' => ['width' => '180px'],
                'value' => function ($model) {
                    $string = '';
                    if(!empty($model->orderItems))foreach ($model->orderItems as $value){
                        $string .= '<p>'.$value->package_item_title.' x'.$value->quantity.'</p>';
                    }

                    return $string;
                }
            ],
//            'package_id',
//             'total_quantity',
            ['attribute' => 'total_quantity', 'headerOptions' => ['width' => '40px']],
             'total_price',
            // 'total_sale_price',
            // 'payment_price',
            // 'discount',
            // 'discount_info:ntext',
             'created_at:datetime',
            // 'updated_at',
            [
                'class' => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'enum' => \common\models\Order::status()
            ],
//            [
//                'class' => \common\grid\EnumColumn::className(),
//                'attribute' => 'payment_type',
//                'enum' => \common\models\Order::paymentTypes()
//            ],
//            [
//                'class' => \common\grid\EnumColumn::className(),
//                'attribute' => 'payment_status',
//                'enum' => \common\models\Order::paymentStatus()
//            ],
            [
                'attribute' => 'payment_type',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\Order::getPaymentTypeForPage($model->payment_type);
                }
            ],
            [
                'attribute' => 'payment_status',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\Order::getPaymentStatusForPage($model->payment_status);
                }
            ],
            [
                'attribute' => 'refund_status',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\Order::getRefundStatusForPage($model->refund_status);
                }
            ],
             'coupon_code',
            // 'contact_name',
            // 'contact_mobile',
            // 'remark',
            // 'after_sale_status',

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '100px'],
                'buttonOptions' => ['style' => 'margin-right: 12px;'],
            ],
        ],
    ]); ?>

</div>
