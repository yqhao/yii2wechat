<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */

$cache = [
//    'class' => 'yii\caching\FileCache',
//    'cachePath' => '@frontend/runtime/cache',
    'class' => 'yii\caching\ApcCache',
    'keyPrefix' => 'front_',
    'useApcu' => true,
    'defaultDuration' => 7200,
];

if (YII_ENV_DEV) {
//    $cache = [
//        'class' => 'yii\caching\DummyCache'
//    ];
}

return $cache;
