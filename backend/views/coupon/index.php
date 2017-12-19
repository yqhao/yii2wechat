<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CouponSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Coupons');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Coupon',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            'amount',
            'title',
//            'description',
            [
                'class' => \common\grid\EnumColumn::className(),
                'attribute' => 'type',
                'enum' => \common\models\Coupon::types()
            ],

            // 'rule:ntext',
             'expiration_date',
            [
                'class' => \common\grid\EnumColumn::className(),
                'attribute' => 'is_used',
                'enum' => [
                    '未使用',
                    '已使用'
                ]
            ],
            // 'order_id',
            // 'user_id',
            // 'created_by',
             'created_at:datetime',


            ['class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '100px'],
                'buttonOptions' => ['style' => 'margin-right: 12px;'],],
        ],
    ]); ?>

</div>
