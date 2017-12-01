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

//            'id',
            [
                'attribute' => 'title',
                'headerOptions' => ['width' => '240px'],
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->packageCategory ? $model->packageCategory->title : null;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\common\models\PackageCategory::find()->all(), 'id', 'title')
            ],
            [
                'attribute' => 'cover',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->cover ? Html::img($model->getCover(), ['style'=>'width: 100%']) : null;
                }
            ],
             'price',
             'market_price',
             'sales',
//            [
//                'class' => \common\grid\EnumColumn::className(),
//                'attribute' => 'is_recommend',
//                'enum' => [
//                    Yii::t('common', 'No'),
//                    Yii::t('common', 'Yes')
//                ]
//            ],
             'stock',
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
             'created_at:datetime',
            // 'updated_at',
            // 'last_update',
            // 'description',
            // 'content:ntext',
            // 'detail:ntext',
            // 'images:ntext',
            // 'address',
            [
                'attribute' => 'id',
                'label' => '门票',
                'format' => 'raw',
//                'headerOptions' => ['width' => '100px'],
                'value' => function ($model) {
                    return Html::a('管理',['/package-item','package_id'=>$model->id]);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '100px'],
                'buttonOptions' => ['style' => 'margin-right: 12px;'],
                'template' => '{view} {update} {delete}'
            ],
        ],
    ]); ?>

</div>
