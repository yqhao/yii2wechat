<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=>true,
    'showScriptName'=>false,
    'rules'=> [
        // Pages
        ['pattern'=>'page/<slug>', 'route'=>'page/view'],

        // Articles
        ['pattern'=>'article/index', 'route'=>'article/index'],
        ['pattern'=>'article/attachment-download', 'route'=>'article/attachment-download'],
        ['pattern'=>'article/<slug>', 'route'=>'article/view'],

        // Api
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/carousel', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/widget-carousel', 'only' => ['getIndexAd','index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/package', 'only' => ['index', 'view','detail','images']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/package-item', 'only' => ['index', 'view']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user-auth', 'only' => ['send-code','check-login']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/order', 'only' => ['index', 'view', 'create','add','check-coupon','pay','detail','cancel','get-payment-info']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/payment-notify', 'only' => ['receive']],
//        'GET api/v1/widget-carousel/getAd' => 'api/v1/widget-carousel/getIndexAd',
    ]
];
