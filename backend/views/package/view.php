<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Package */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-view">

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
//            'app_id',
            [
                'attribute' => 'category_id',
                'value' => $model->packageCategory->title,
            ],
            'title',
            [
                'attribute' => 'cover',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->cover ? Html::img($model->getCover(), ['style'=>'width: 100%']) : null;
                }
            ],
            [
                'attribute' => 'images',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->packageImages){
                        return Html::a('查看更多>>',['/package-image','package_id'=>$model->id]);
                    }
                }
            ],
//            'images:ntext',
            'price',
            'market_price',
            [
                'attribute' => 'id',
                'label' => '门票',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->packageItems){
                        return Html::a('查看更多>>',['/package-item','package_id'=>$model->id]);
                    }
                }
            ],
            'sales',
//            'is_recommend',
            'stock',
//            'weight',
//            'goods_type',
//            'max_can_use_integral',
//            'integral',
//            'express_rule_id',
//            'is_seckill',
//            'seckill_status',
//            'is_group_buy',
            'is_published',
            'created_at:datetime',
            'updated_at:datetime',
            'last_update',
            'description',

            'detail:ntext',
            'purchase_notice:ntext',
            'traffic_guide:ntext',
            'province_id',
            'city_id',
            'county_id',
            'address',
        ],
    ]) ?>

</div>
