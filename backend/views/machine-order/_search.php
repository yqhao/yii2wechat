<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\MachineOrderSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="machine-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'franchisee_id') ?>

    <?php echo $form->field($model, 'member_id') ?>

    <?php echo $form->field($model, 'status') ?>

    <?php echo $form->field($model, 'is_distributed') ?>

    <?php // echo $form->field($model, 'entered_money') ?>

    <?php // echo $form->field($model, 'spend_money') ?>

    <?php // echo $form->field($model, 'point_money') ?>

    <?php // echo $form->field($model, 'gai_discount') ?>

    <?php // echo $form->field($model, 'member_discount') ?>

    <?php // echo $form->field($model, 'distribute_money') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'machine_id') ?>

    <?php // echo $form->field($model, 'symbol') ?>

    <?php // echo $form->field($model, 'distribute_config') ?>

    <?php // echo $form->field($model, 'auto_check_fail') ?>

    <?php // echo $form->field($model, 'is_auto') ?>

    <?php // echo $form->field($model, 'distributed_time') ?>

    <?php // echo $form->field($model, 'pay_type') ?>

    <?php // echo $form->field($model, 'gai_number') ?>

    <?php // echo $form->field($model, 'order_key_id_str') ?>

    <?php // echo $form->field($model, 'gcp_order_code') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
