<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Machine */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="machine-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'm_id')->textInput() ?>

    <?php echo $form->field($model, 'm_code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'm_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'city_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'dist_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'last_time')->textInput() ?>

    <?php echo $form->field($model, 'max_amount')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'city_id')->textInput() ?>

    <?php echo $form->field($model, 'dist_id')->textInput() ?>

    <?php echo $form->field($model, 'order_count')->textInput() ?>

    <?php echo $form->field($model, 'order_amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
