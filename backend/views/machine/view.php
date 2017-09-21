<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Machine */

$this->title = $model->m_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Machines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->m_id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->m_id], [
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
            'm_id',
            'm_code',
            'm_name',
            'city_name',
            'dist_name',
            'street',
            'last_time',
            'max_amount',
            'city_id',
            'dist_id',
            'order_count',
            'order_amount',
        ],
    ]) ?>

</div>
