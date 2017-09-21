<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Machine */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Machine',
]) . ' ' . $model->m_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Machines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->m_id, 'url' => ['view', 'id' => $model->m_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="machine-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
