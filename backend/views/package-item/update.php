<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PackageItem */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Package Item',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Package Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="package-item-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
