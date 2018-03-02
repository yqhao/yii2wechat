<?php
\moonland\phpexcel\Excel::widget([
    'models' => $data,
    'mode' => 'export', //default value as 'export'
    'fileName' => 'order', //default value as 'export'
//    'format'=>'Excel2007',
    'columns' => [
        [
            'attribute' => 'code',
            'value' => function ($model) {
                return "\t".$model->code;
            }
        ],
        'package_title',
        [
            'attribute' => 'package_id',
            'value' => function ($model) {
                $string = '';
                if(!empty($model->orderItems))foreach ($model->orderItems as $value){
                    $string .= $value->package_item_title.'， 预订数量:'.$value->quantity.'，　预订日期:'.$value->use_date."．\n";
                }
                return $string;
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => 'text',
            'value' => function ($model) {
                return date('Y-m-d H:i:s',$model->created_at);
            }
        ],
        'contact_name',
        [
            'attribute' => 'contact_mobile',
            'value' => function ($model) {
                return "\t".$model->contact_mobile;
            }
        ],
        [
            'attribute' => 'contact_id_number',
            'value' => function ($model) {
                return "\t".$model->contact_id_number;
            }
        ],
        'total_price:decimal','payment_price:decimal',
        [
            'attribute' => 'payment_status',
            'format' => 'text',
            'value' => function ($model) {
                return \common\models\Order::paymentStatus($model->payment_status);
            }
        ],
        [
            'attribute' => 'payment_type',
            'format' => 'text',
            'value' => function ($model) {
                return \common\models\Order::paymentTypes($model->payment_type);
            }
        ],
        [
            'attribute' => 'refund_status',
            'format' => 'text',
            'value' => function ($model) {
                return \common\models\Order::refundStatus($model->refund_status);
            }
        ],
        'coupon_code',
    ], //without header working, because the header will be get label from attribute label.
    'headers' => ['code' => '订单号','package_title'=>'景点','created_at' => '下单时间', 'contact_name' => '联系人','contact_mobile'=>'手机号','contact_id_number'=>'身份证号','total_price'=>'总价','payment_price'=>'支付金额','payment_status'=>'支付状态','payment_type'=>'支付类型','coupon_code'=>'优惠码','refund_status'=>'退款状态','package_id'=>'门票'],
]);

redirect(Yii::$app->request->referrer);
?>