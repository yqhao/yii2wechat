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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Order',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'package_title',
            'user_id',
            'package_id',
            // 'total_quantity',
            // 'total_price',
            // 'total_sale_price',
            // 'payment_price',
            // 'discount',
            // 'discount_info:ntext',
            // 'created_at',
            // 'updated_at',
            // 'status',
            // 'payment_type',
            // 'payment_status',
            // 'coupon_code',
            // 'contact_name',
            // 'contact_mobile',
            // 'remark',
            // 'after_sale_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
