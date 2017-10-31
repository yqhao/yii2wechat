<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Package */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Package',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="package-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
