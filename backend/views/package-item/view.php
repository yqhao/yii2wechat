<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PackageItem */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Package Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-item-view">

    <p>
        <?php echo Html::a('< 返回', Yii::$app->request->referrer, ['class' => 'btn bg-purple']) ?>
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
            [
                'attribute' => 'package_id',
                'label' => '主题',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->package_id ? $model->package->title : null;
                }
            ],
            'title',
            'description',
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
            'weekend_price',
            'holiday_price',
            'booking_advance',
            'sales',
            'stock',

            'is_published',

            'last_update',
            'detail:ntext',
            'special_description:ntext',
            'unsubscribe_rules:ntext',
            'change_rules:ntext',
            'important_clause:ntext',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
