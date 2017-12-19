<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserWechat */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'User Wechat',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User Wechats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-wechat-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
