<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Package */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Package',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Packages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="package-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
