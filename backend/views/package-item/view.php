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
            'package_id',
            'title',
            'cover',
            'price',
            'sales',
            'stock',
            'weight',
            'max_can_use_integral',
            'integral',
            'is_published',
            'create_at',
            'update_at',
            'last_update',
            'content:ntext',
        ],
    ]) ?>

</div>
