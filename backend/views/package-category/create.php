<?php
/* @var $this yii\web\View */
/* @var $model common\models\PackageCategory */
/* @var $categories common\models\PackageCategory[] */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Package Category',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Package Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'categories' => $categories
    ]) ?>

</div>
