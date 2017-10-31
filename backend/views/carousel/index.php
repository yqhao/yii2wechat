<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CarouselSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Carousels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Carousel',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'compId',
            'type',
            'style:ntext',
            'content:ntext',
            // 'animations:ntext',
            // 'customFeature',
            // 'page_form',
            // 'is_published',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
