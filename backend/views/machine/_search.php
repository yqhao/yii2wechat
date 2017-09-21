<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\MachineSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="machine-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'm_id') ?>

    <?php echo $form->field($model, 'm_code') ?>

    <?php echo $form->field($model, 'm_name') ?>

    <?php echo $form->field($model, 'city_name') ?>

    <?php echo $form->field($model, 'dist_name') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'last_time') ?>

    <?php // echo $form->field($model, 'max_amount') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'dist_id') ?>

    <?php // echo $form->field($model, 'order_count') ?>

    <?php // echo $form->field($model, 'order_amount') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
