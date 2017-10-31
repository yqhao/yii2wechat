<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PackageItem */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Package Item',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Package Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-item-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
