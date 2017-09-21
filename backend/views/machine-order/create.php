<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MachineOrder */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Machine Order',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Machine Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-order-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
