<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\CarouselSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="carousel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'compId') ?>

    <?php echo $form->field($model, 'type') ?>

    <?php echo $form->field($model, 'style') ?>

    <?php echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'animations') ?>

    <?php // echo $form->field($model, 'customFeature') ?>

    <?php // echo $form->field($model, 'page_form') ?>

    <?php // echo $form->field($model, 'is_published') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
