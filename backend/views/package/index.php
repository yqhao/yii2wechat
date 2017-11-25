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
//            'app_id',
//            [
//                'label' => '分类',
//                'attribute' => 'category_name',
//                'value' => 'packageCategory.title',
//            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->packageCategory ? $model->packageCategory->title : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\PackageCategory::find()->all(), 'id', 'title')
            ],
//            'title',
            [
                'attribute' => 'title',
                'headerOptions' => ['width' => '240px'],
            ],
//            'cover',
            [
                'attribute' => 'cover',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->cover ? Html::img($model->getImageUrl(), ['style'=>'width: 100%']) : null;
                }
            ],
             'price',
             'market_price',
            // 'sales',
            [
                'class' => \common\grid\EnumColumn::className(),
                'attribute' => 'is_recommend',
                'enum' => [
                    Yii::t('common', 'No'),
                    Yii::t('common', 'Yes')
                ]
            ],
            // 'stock',
            // 'weight',
            // 'goods_type',
            // 'max_can_use_integral',
            // 'integral',
            // 'express_rule_id',
            // 'is_seckill',
            // 'seckill_status',
            // 'is_group_buy',
            [
                'class' => \common\grid\EnumColumn::className(),
                'attribute' => 'is_published',
                'enum' => [
                    Yii::t('backend', 'Not Published'),
                    Yii::t('backend', 'Published')
                ]
            ],
             'create_at:datetime',
            // 'update_at',
            // 'last_update',
            // 'description',
            // 'content:ntext',
            // 'detail:ntext',
            // 'images:ntext',
            // 'address',

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '100px'],
                'buttonOptions' => ['style' => 'margin-right: 12px;'],
                'template' => '{view} {update} {delete}'
            ],
        ],
    ]); ?>

</div>
