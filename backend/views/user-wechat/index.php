<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserWechatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'User Wechats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-wechat-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?php //echo Html::a(Yii::t('backend', 'Create {modelClass}', [
//    'modelClass' => 'User Wechat',
//]), ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'openid',
//            'user_id',
//            'code',
            'nickname',
//            'session_key',
            // 'unionid',
            // 'user_info:ntext',
             'created_at:datetime',
            // 'updated_at',
//             'status',
            // 'token',
            // 'expire_at',
            // 'auth_key',
             'logged_at:datetime',
//             'remark',
            [
                'class' => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'enum' => \common\models\UserWechat::statuses()
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['width' => '100px'],
                'buttonOptions' => ['style' => 'margin-right: 12px;'],
                'template' => '{view} {update}'
            ],
        ],
    ]); ?>

</div>
