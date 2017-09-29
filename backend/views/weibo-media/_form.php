<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WeiboMedia */
/* @var $form yii\bootstrap\ActiveForm */
?>
<?php if(!empty($medias)): ?>
    <div>
        <span>抓取结果:</span></br>
        <?php foreach ($medias as $name => $src): ?>
            <a target="_blank" href="<?= $src;?>"><?= $name;?></a></br></br>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<div class="weibo-media-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php echo $form->field($model, 'is_vedio')->checkbox() ?>
    <?php echo $form->field($model, 'page_url')->textarea(['rows' => 2]) ?>

    <?php //echo $form->field($model, 'media_url')->textarea(['rows' => 3]) ?>
    <?php echo $form->field($model, 'is_save')->checkbox() ?>
    <?php echo $form->field($model, 'save_path')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
