<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Package */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $categories array */
?>

<div class="package-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

<!--    --><?php //echo $form->field($model, 'app_id')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'category_id')->dropDownList($categories, ['prompt'=>'']) ?>
    
    <?php echo $form->field($model, 'coverUpload')->widget(
        \trntv\filekit\widget\Upload::className(),
        [
            'url'=>['/file-storage/upload'],
        ]
    ) ?>
    <?php echo $form->field($model, 'imagesUpload')->widget(
        \trntv\filekit\widget\Upload::className(),
        [
            'url'=>['/file-storage/upload'],
            'multiple' => true,
            'maxNumberOfFiles' => 5
        ]
    ) ?>

    <?php echo $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'market_price')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'sales')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'is_recommend')->textInput() ?>

    <?php echo $form->field($model, 'stock')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'weight')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'goods_type')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'max_can_use_integral')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'integral')->textInput(['maxlength' => true]) ?>

<!--    --><?php //echo $form->field($model, 'express_rule_id')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'is_seckill')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'seckill_status')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'is_group_buy')->textInput() ?>

    <?php echo $form->field($model, 'is_published')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'create_at')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'update_at')->textInput() ?>

<!--    --><?php //echo $form->field($model, 'last_update')->textInput() ?>

    <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'province_id')->textInput() ?>
    <?php echo $form->field($model, 'city_id')->textInput() ?>
    <?php echo $form->field($model, 'county_id')->textInput() ?>
    <?php echo $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'detail')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'lang' => 'zh_cn',
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>
    <?php echo $form->field($model, 'purchase_notice')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'lang' => 'zh_cn',
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>
    <?php echo $form->field($model, 'traffic_guide')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'lang' => 'zh_cn',
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>



    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
