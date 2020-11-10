<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@webroot' => dirname(dirname(__FILE__)) . '/web',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'CDN' => [
            'class' => 'app\modules\media\components\CDN',
            "cloud_name" => "kotofey-store",
            "api_key" => "313768283447262",
            "api_secret" => "Wm28QI4nQIolSV1J7Hd0hArxuzM",
            "secure" => true
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,

    'controllerMap' => [
//        'fixture' => [ // Fixture generation command line.
//            'class' => 'yii\faker\FixtureController',
//        ],
        'migration' => [
            'class' => 'bizley\migration\controllers\MigrationController',
        ],
        'sibagro' => [
            'class' => 'app\modules\catalog\console\SibagroController'
        ],
        'backup' => [
            'class' => 'app\modules\site\console\BackupController'
        ],
        'content' => [
            'class' => 'app\modules\content\console\ContentController'
        ],
    ],

];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
