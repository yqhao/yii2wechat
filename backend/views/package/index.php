<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Packages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Package',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'app_id',
            'category_id',
            'title',
            'cover',
            // 'price',
            // 'sale_price',
            // 'sales',
            // 'is_recommend',
            // 'stock',
            // 'weight',
            // 'goods_type',
            // 'max_can_use_integral',
            // 'integral',
            // 'express_rule_id',
            // 'is_seckill',
            // 'seckill_status',
            // 'is_group_buy',
            // 'is_published',
            // 'create_at',
            // 'update_at',
            // 'last_update',
            // 'description',
            // 'content:ntext',
            // 'detail:ntext',
            // 'images:ntext',
            // 'address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
