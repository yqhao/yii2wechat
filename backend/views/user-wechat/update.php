<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserWechat */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'User Wechat',
]) . ' ' . $model->openid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User Wechats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->openid, 'url' => ['view', 'id' => $model->openid]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="user-wechat-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
