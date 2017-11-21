<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Region */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Region',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Regions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
