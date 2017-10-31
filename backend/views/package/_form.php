<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Package */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'app_id')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'category_id')->textInput() ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'cover')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'sales')->textInput() ?>

    <?php echo $form->field($model, 'is_recommend')->textInput() ?>

    <?php echo $form->field($model, 'stock')->textInput() ?>

    <?php echo $form->field($model, 'weight')->textInput() ?>

    <?php echo $form->field($model, 'goods_type')->textInput() ?>

    <?php echo $form->field($model, 'max_can_use_integral')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'integral')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'express_rule_id')->textInput() ?>

    <?php echo $form->field($model, 'is_seckill')->textInput() ?>

    <?php echo $form->field($model, 'seckill_status')->textInput() ?>

    <?php echo $form->field($model, 'is_group_buy')->textInput() ?>

    <?php echo $form->field($model, 'is_published')->textInput() ?>

    <?php echo $form->field($model, 'create_at')->textInput() ?>

    <?php echo $form->field($model, 'update_at')->textInput() ?>

    <?php echo $form->field($model, 'last_update')->textInput() ?>

    <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'images')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
