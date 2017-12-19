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
        <?php echo Yii::t('backend', 'You have new user!') ?>
    </h3>

    <div class="timeline-body">
        <?php $nickname = \common\models\UserWechat::find()->andWhere(['openid'=>$model->data['openid']])->select('nickname')->scalar();?>
        <?php echo Yii::t('backend', 'New user ({identity}) was registered at {created_at}', [
            'identity' => $nickname,
            'created_at' => Yii::$app->formatter->asDatetime($model->data['created_at'])
        ]) ?>
    </div>

    <div class="timeline-footer">
        <?php echo \yii\helpers\Html::a(
            Yii::t('backend', 'View user'),
            ['/user-wechat/view', 'id' => $model->data['openid']],
            ['class' => 'btn btn-success btn-sm']
        ) ?>
    </div>
</div>