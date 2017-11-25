<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\PackageSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="package-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>

    <?php echo $form->field($model, 'app_id') ?>

    <?php echo $form->field($model, 'category_id') ?>

    <?php echo $form->field($model, 'title') ?>

    <?php echo $form->field($model, 'cover') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'sales') ?>

    <?php // echo $form->field($model, 'is_recommend') ?>

    <?php // echo $form->field($model, 'stock') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'goods_type') ?>

    <?php // echo $form->field($model, 'max_can_use_integral') ?>

    <?php // echo $form->field($model, 'integral') ?>

    <?php // echo $form->field($model, 'express_rule_id') ?>

    <?php // echo $form->field($model, 'is_seckill') ?>

    <?php // echo $form->field($model, 'seckill_status') ?>

    <?php // echo $form->field($model, 'is_group_buy') ?>

    <?php // echo $form->field($model, 'is_published') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'last_update') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <?php // echo $form->field($model, 'images') ?>

    <?php // echo $form->field($model, 'address') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
