<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WeiboMedia */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Weibo Media',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Weibo Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="weibo-media-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
