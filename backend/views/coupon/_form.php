<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Coupon */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="coupon-form">
    <p><?php echo Html::a('< 返回', \backend\components\UrlHelper::getPreUrl(), ['class' => 'btn bg-purple']) ?></p>
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'type')->textInput() ?>
    <?php echo $form->field($model, 'type')->radioList(\common\models\Coupon::types()) ?>

    <?php echo $form->field($model, 'rule')->widget(
        trntv\aceeditor\AceEditor::className(),
        [
            'mode' => 'json',
            'containerOptions' => [
                'style' => 'width: 100%; min-height: 100px'
            ]
        ]
    ) ?>

    <?php echo $form->field($model, 'expiration_date')->textInput() ?>

    <?php echo $form->field($model, 'is_used')->checkbox(['label'=>'已使用']) ?>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
