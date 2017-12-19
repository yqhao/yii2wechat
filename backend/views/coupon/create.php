<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Coupon */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Coupon',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coupons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-create">

    <p><?php echo Html::a('< 返回', Yii::$app->request->referrer, ['class' => 'btn bg-purple']) ?></p>
    <div class="coupon-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'type')->textInput(['value'=>'1']) ?>

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


        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
