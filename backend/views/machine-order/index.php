<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MachineOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Machine Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-order-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?php //echo Html::a(Yii::t('backend', 'Create {modelClass}', [
//    'modelClass' => 'Machine Order',
//]), ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'franchisee_id',
            //'member_id',
            //'status',
            //'is_distributed',
             //'entered_money',
             'spend_money',
             'point_money',
             'gai_discount',
             //'member_discount',
             //'distribute_money',
             'create_time:datetime',
             //'remark',
             'machine_id',
             //'symbol',
             //'distribute_config',
             'auto_check_fail',
             //'is_auto',
             //'distributed_time:datetime',
            [
                //'label'=>'创建日期',
                'attribute' => 'pay_type',
                'value' => function($data) {
                    return $data->pay_type == 1 ? $data->pay_type.'积分' : $data->pay_type.'现金'; }
            ],
             'gai_number',
             //'order_key_id_str',
             //'gcp_order_code',

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ],
    ]); ?>

</div>
