<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Coupon */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coupons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-view">

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
            'code',
            'amount',
            'title',
            'description',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\Coupon::types($model->type);
                }
            ],
            'rule:ntext',
            'expiration_date',
            [
                'attribute' => 'is_used',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_used == 1 ? '已使用' : '未使用';
                }
            ],
            'order_id',
            'user_id',
            'created_by',
            'created_at:datetime',
        ],
    ]) ?>

</div>
