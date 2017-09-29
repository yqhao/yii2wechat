<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WeiboMedia */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Weibo Media',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Weibo Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weibo-media-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'mediasLocal' => $mediasLocal,
        'medias' => $medias
    ]) ?>

</div>
