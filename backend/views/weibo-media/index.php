<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Weibo Media');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="weibo-media-index">


    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Weibo Media',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'page_url:ntext',
            'media_url:ntext',
            'save_path:ntext',
            'is_save',
            // 'is_vedio',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
