<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\OrderItemSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="order-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'order_id') ?>

    <?php echo $form->field($model, 'package_id') ?>

    <?php echo $form->field($model, 'package_item_id') ?>

    <?php echo $form->field($model, 'package_item_title') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'use_date') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
