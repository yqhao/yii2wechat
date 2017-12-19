<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 * @var $model common\models\TimelineEvent
 */
?>
<div class="timeline-item">
    <span class="time">
        <i class="fa fa-clock-o"></i>
        <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
    </span>

    <h3 class="timeline-header">
        <?php echo Yii::t('backend', '你用新的已支付订单!') ?>
    </h3>

    <div class="timeline-body">
        <?php echo Yii::t('backend', '新订单 ({identity}) 在 {created_at} 成功付款', [
            'identity' => $model->data['package_title'],
            'created_at' => Yii::$app->formatter->asDatetime($model->data['created_at'])
        ]) ?>
    </div>

    <div class="timeline-footer">
        <?php echo \yii\helpers\Html::a(
            Yii::t('backend', '查看订单'),
            ['/order/view', 'id' => $model->data['order_id']],
            ['class' => 'btn btn-success btn-sm']
        ) ?>
    </div>
</div>