<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Machine */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Machine',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Machines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
