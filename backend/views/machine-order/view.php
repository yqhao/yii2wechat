<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MachineOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Machine Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-order-view">

<!--    <p>-->
<!--        --><?php //echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<!--        --><?php //echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ]) ?>
<!--    </p>-->

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'franchisee_id',
            'member_id',
            'status',
            'is_distributed',
            'entered_money',
            'spend_money',
            'point_money',
            'gai_discount',
            'member_discount',
            'distribute_money',
            'create_time:datetime',
            'remark',
            'machine_id',
            'symbol',
            'distribute_config',
            'auto_check_fail',
            'is_auto',
            'distributed_time:datetime',
            'pay_type',
            'gai_number',
            'order_key_id_str',
            'gcp_order_code',
        ],
    ]) ?>

</div>
