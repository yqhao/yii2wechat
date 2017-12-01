<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrderItem */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Order Item',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Order Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
