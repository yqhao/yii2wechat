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
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'package_title',
            'user_id',
            'package_id',
            'total_quantity',
            'total_price',
            'total_sale_price',
            'payment_price',
            'discount',
            'discount_info:ntext',
            'created_at',
            'updated_at',
            'status',
            'payment_type',
            'payment_status',
            'coupon_code',
            'contact_name',
            'contact_mobile',
            'remark',
            'after_sale_status',
        ],
    ]) ?>

</div>
