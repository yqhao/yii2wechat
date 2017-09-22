<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MachineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Machines');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Machine',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'm_id',
            //'m_code',
            'm_name',
            'city_name',
            'dist_name',
             'street',
             'last_time',
             'max_amount',
            // 'city_id',
            // 'dist_id',
            // 'order_count',
            // 'order_amount',
            [
                'attribute' => 'order_counts',
                'label'=>'订单总数',
                'value'=>
                    function($model){
                        return  count($model->machineOrders);
                    },
                'headerOptions' => ['width' => '80'],
            ],
            [
                'attribute' => 'order_amounts',
                'label'=>'订单总额',
                'value'=>
                    function($model){
                        return  ($model->machineOrderAmount);
                    },
                'headerOptions' => ['width' => '80'],
            ],
            //['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
            [
                'header' => "查看",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {update}',
                'headerOptions' => ['width' => '140'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('查看', [
                            'machine/view','id'=>$model->m_id
                        ], ['class' => 'btn btn-xs btn-success','target'=>'_blank']
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('订单', [
                            'machine-order/index','MachineOrderSearch[machine_id]'=>$model->m_id
                            ], ['class' => 'btn btn-xs btn-info','target'=>'_blank']
                        );
                    }

                ]
            ],
        ],
    ]); ?>

</div>
