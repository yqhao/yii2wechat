<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="order-form">
    <p><?php echo Html::a('< 返回', Yii::$app->request->referrer, ['class' => 'btn bg-purple']) ?></p>

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

<!--    --><?php //echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'package_title')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'user_id')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'package_id')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'total_quantity')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'total_sale_price')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'payment_price')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'discount_info')->textarea(['rows' => 6]) ?>

<!--    --><?php //echo $form->field($model, 'created_at')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'updated_at')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'status')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'payment_type')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'payment_status')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'coupon_code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'contact_name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'contact_mobile')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'after_sale_status')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
