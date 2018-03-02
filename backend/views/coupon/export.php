<?php
\moonland\phpexcel\Excel::widget([
    'models' => $data,
    'mode' => 'export', //default value as 'export'
    'fileName' => 'coupon', //default value as 'export'
    'columns' => [
        [
            'attribute' => 'code',
            'value' => function ($model) {
                return "\t".$model->code;
            }
        ],
        'title',
        'amount:decimal',
        'expiration_date',
        [
            'attribute' => 'is_used',
            'format' => 'text',
            'value' => function ($model) {
                return $model->is_used == 1 ? '已使用' : '未使用';
            }
        ],

    ], //without header working, because the header will be get label from attribute label.
    'headers' => ['code' => '优惠码','title'=>'名称','amount'=>'金额','expiration_date' => '过期时间', 'is_used' => '使用情况',],
]);

redirect(Yii::$app->request->referrer);
?>