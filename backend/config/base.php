<?php
return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
//    'sourceLanguage'=>'zh-CN',
//    'language'=>'zh-CN',
    'components' => [
        'urlManager' => require __DIR__.'/_urlManager.php',
        'frontendCache' => require Yii::getAlias('@frontend/config/_cache.php')
    ],
];
