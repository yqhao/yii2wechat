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
            'status',
            'payment_type',
            'payment_status',
            'coupon_code',
            'after_sale_status',
        ],
    ]) ?>

</div>
