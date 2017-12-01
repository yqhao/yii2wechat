<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\OrderItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Order Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Order Item',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'order_id',
            'package_id',
            'package_item_id',
            'package_item_title',
            // 'price',
            // 'sale_price',
            // 'quantity',
            // 'use_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
