<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrderItem */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="order-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'order_id')->textInput() ?>

    <?php echo $form->field($model, 'package_id')->textInput() ?>

    <?php echo $form->field($model, 'package_item_id')->textInput() ?>

    <?php echo $form->field($model, 'package_item_title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'quantity')->textInput() ?>

    <?php echo $form->field($model, 'use_date')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
