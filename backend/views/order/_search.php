<?php
use common\models\Order;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use trntv\yii\datetime\DateTimeWidget;
/* @var $this yii\web\View */
/* @var $model backend\models\search\OrderSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>
<div class="box box-default collapsed-box">
<div class="box-header with-border">
    <h3 class="box-title">高级查询</h3>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
    </div>
</div>
<div class="box-body" style="display: none;">
<!--<div class="order-search">-->

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                <?php echo $form->field($model, 'code') ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->field($model, 'coupon_code') ?>
            </div>
            <div class="col-md-3">
                <?php echo $form->field($model, 'created_at_start')->widget(
                    DateTimeWidget::className(),
                    [
                        'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
                    ]
                )->label('下单时间开始') ?>
            </div>
            <div class="col-md-3">
            <?php echo $form->field($model, 'created_at_end')->widget(
                DateTimeWidget::className(),
                [
                    'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
                ]
            )->label('下单时间结束') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <?php echo $form->field($model, 'status')->dropDownList(ArrayHelper::merge([''=>'全部'],Order::status())); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->field($model, 'payment_type')->dropDownList(ArrayHelper::merge([''=>'全部'],Order::paymentTypes())); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->field($model, 'payment_status')->dropDownList(ArrayHelper::merge([''=>'全部'],Order::paymentStatus())); ?>
            </div>
            <div class="col-md-2">
                <?php echo $form->field($model, 'refund_status')->dropDownList(ArrayHelper::merge([''=>'全部'],Order::refundStatus())); ?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>