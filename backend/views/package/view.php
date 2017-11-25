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
            'cover',
            'price',
            'market_price',
            'sales',
            'is_recommend',
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
            'create_at',
            'update_at',
            'last_update',
            'description',
            'content:ntext',
            'detail:ntext',
            'images:ntext',
            'address',
        ],
    ]) ?>

</div>
