<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\UserWechatSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-wechat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'openid') ?>

    <?php echo $form->field($model, 'user_id') ?>

    <?php echo $form->field($model, 'code') ?>

    <?php echo $form->field($model, 'nickname') ?>

    <?php echo $form->field($model, 'session_key') ?>

    <?php // echo $form->field($model, 'unionid') ?>

    <?php // echo $form->field($model, 'user_info') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'expire_at') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'logged_at') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
