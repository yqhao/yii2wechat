<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\PackageImage */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Package Image',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Package Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-image-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
