<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PackageItem */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="package-item-form">
    <p><?php echo Html::a('< 返回', ['index','package_id'=>$model->package_id], ['class' => 'btn bg-purple']) ?></p>
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'package_id')->hiddenInput()->label(false); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'coverUpload')->widget(
        \trntv\filekit\widget\Upload::className(),
        [
            'url'=>['/file-storage/upload'],
        ]
    ) ?>

    <?php echo $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'market_price')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'price_rise_at_weekend')->textInput(['value'=>'+0']) ?>
    <?php echo $form->field($model, 'price_rise_at_holiday')->textInput(['value'=>'+0']) ?>
    <?php echo $form->field($model, 'booking_advance')->textInput(['value'=>'-1']) ?>

    <?php echo $form->field($model, 'stock')->textInput() ?>


    <?php $model->is_published = ($model->is_published === null || $model->is_published ==='') ? 1 : $model->is_published ; ?>


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
    <?php echo $form->field($model, 'special_description')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'lang' => 'zh_cn',
                'minHeight' => 200,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>
    <?php echo $form->field($model, 'unsubscribe_rules')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'lang' => 'zh_cn',
                'minHeight' => 200,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>

    <?php echo $form->field($model, 'change_rules')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'lang' => 'zh_cn',
                'minHeight' => 200,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>


    <?php echo $form->field($model, 'important_clause')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'lang' => 'zh_cn',
                'minHeight' => 200,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>

    <!--    --><?php //echo $form->field($model, 'is_published')->radioList(['0'=>'否','1'=>'是']) ?>
    <?php echo $form->field($model, 'is_published')->checkbox(['label'=>'发布']) ?>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
