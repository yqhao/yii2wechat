<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserWechat */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-wechat-form">
    <p><?php echo Html::a('< 返回', \backend\components\UrlHelper::getPreUrl(), ['class' => 'btn bg-purple']) ?></p>
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'status')->dropDownList(\common\models\UserWechat::statuses()) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
