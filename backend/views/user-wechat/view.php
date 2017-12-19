<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserWechat */

$this->title = $model->openid;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User Wechats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-wechat-view">

    <p>
        <?php echo Html::a('< 返回', ['index'], ['class' => 'btn bg-purple']) ?>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->openid], ['class' => 'btn btn-primary']) ?>
<!--        --><?php //echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->openid], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'openid',
            'user_id',
            'code',
            'nickname',
//            'session_key',
//            'unionid',
//            'user_info:ntext',
            [
                'label' => '用户信息',
                'attribute' => 'user_info',
                'format' => 'raw',
                'value' => function ($model) {
                    $string = null;
                    if($model->user_info){
                        $userInfo = \GuzzleHttp\json_decode($model->user_info);
                        $string = '<table>';
                        $string .= '<tr><td width="80px;"><img style="width: 60px;height: 60px;" src="'.$userInfo->avatarUrl.'"></td><td width="120px;">'.$userInfo->nickName.'</td><td width="180px;">'.$userInfo->province.' / '.$userInfo->city.'</td></tr>';
                        $string .= '</table>';
                    }

                    return $string;
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
//            'status',
//            'token',
//            'expire_at',
//            'auth_key',
            'logged_at:datetime',
//            'remark',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $ary = \common\models\UserWechat::statuses();
                    return isset($ary[$model->status]) ? $ary[$model->status] : null;
                }
            ],
        ],
    ]) ?>

</div>
