<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MachineOrder */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="machine-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'id')->textInput() ?>

    <?php echo $form->field($model, 'franchisee_id')->textInput() ?>

    <?php echo $form->field($model, 'member_id')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'is_distributed')->textInput() ?>

    <?php echo $form->field($model, 'entered_money')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'spend_money')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'point_money')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'gai_discount')->textInput() ?>

    <?php echo $form->field($model, 'member_discount')->textInput() ?>

    <?php echo $form->field($model, 'distribute_money')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'create_time')->textInput() ?>

    <?php echo $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'machine_id')->textInput() ?>

    <?php echo $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'distribute_config')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'auto_check_fail')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'is_auto')->textInput() ?>

    <?php echo $form->field($model, 'distributed_time')->textInput() ?>

    <?php echo $form->field($model, 'pay_type')->textInput() ?>

    <?php echo $form->field($model, 'gai_number')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'order_key_id_str')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'gcp_order_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
