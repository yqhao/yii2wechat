<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PackageImage */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Package Image',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Package Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="package-image-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
