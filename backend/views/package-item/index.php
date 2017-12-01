<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PackageItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Package Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Package Item',
]), ['create','package_id'=>$package_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'package_id',
            'title',
            [
                'attribute' => 'cover',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->cover ? Html::img($model->getCover(), ['style'=>'width: 100%']) : null;
                }
            ],
            'price',
            'market_price',
            'price_rise_at_weekend',
            'price_rise_at_holiday',
            'booking_advance',
            'sales',
            'stock',

            'is_published',

            // 'sales',
            // 'stock',
            // 'weight',
            // 'max_can_use_integral',
            // 'integral',
            // 'is_published',
            // 'create_at',
            // 'update_at',
            // 'last_update',
            // 'content:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
