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
        'admission' => [
            'class' => 'app\modules\catalog\console\AdmissionController'
        ],
        'sibagro' => [
            'class' => 'app\modules\catalog\console\SibagroController'
        ],
        'valta' => [
            'class' => 'app\modules\catalog\console\ValtaController'
        ],
        'backup' => [
            'class' => 'app\modules\site\console\BackupController'
        ],
        'instagram' => [
            'class' => 'app\modules\instagram\console\InstagramTokenController'
        ],
        'content' => [
            'class' => 'app\modules\content\console\ContentController'
        ],
    ],
    'modules' => [
        'catalog' => [
            'class' => 'app\modules\catalog\Module',
        ],
        'order' => [
            'class' => 'app\modules\order\Module',
        ],
        'logistic' => [
            'class' => 'app\modules\logistic\Module',
        ],
        'site' => [
            'class' => 'app\modules\site\Module',
        ],
        'instagram' => [
            'class' => 'app\modules\instagram\Module',
        ],
        'statistic' => [
            'class' => 'app\modules\statistic\Module',
        ],
        'promocode' => [
            'class' => 'app\modules\promocode\Module',
        ],
        'export' => [
            'class' => 'app\modules\export\Module',
        ],
        'rest' => [
            'class' => 'app\modules\rest\Module',
        ],
        'bot' => [
            'class' => 'app\modules\bot\Module',
        ],
        'feed' => [
            'class' => 'app\modules\feed\Module',
        ],
        'content' => [
            'class' => 'app\modules\content\Module',
        ],
        'delivery' => [
            'class' => 'app\modules\delivery\Module',
        ],
        'payment' => [
            'class' => 'app\modules\payment\Module',
        ],
        'news' => [
            'class' => 'app\modules\news\Module',
        ],
        'stock' => [
            'class' => 'app\modules\stock\Module',
        ],
        'vendors' => [
            'class' => 'app\modules\vendors\Module',
        ],
        'geo' => [
            'class' => 'app\modules\geo\Module',
        ],
        'support' => [
            'class' => 'app\modules\support\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'short_link' => [
            'class' => 'app\modules\short_link\Module',
        ],
        'vacancy' => [
            'class' => 'app\modules\vacancy\Module',
        ],
        'basket' => [
            'class' => 'app\modules\basket\Module',
        ],
        'search' => [
            'class' => 'app\modules\search\Module',
        ],
        'subscribe' => [
            'class' => 'app\modules\subscribe\Module',
        ],
        'site_settings' => [
            'class' => 'app\modules\site_settings\Module',
        ],
        'todo' => [
            'class' => 'app\modules\todo\Module',
        ],
        'bonus' => [
            'class' => 'app\modules\bonus\Module',
        ],
        'compare' => [
            'class' => 'app\modules\compare\Module',
        ],
        'favorite' => [
            'class' => 'app\modules\favorite\Module',
        ],
        'rbac' => [
            'class' => 'app\modules\rbac\Module',
        ],
        'menu' => [
            'class' => 'app\modules\menu\Module',
        ],
        'menu_fast' => [
            'class' => 'app\modules\menu_fast\Module',
        ],
        'pets' => [
            'class' => 'app\modules\pets\Module',
        ],
        'logger' => [
            'class' => 'app\modules\logger\Module',
        ],
        'promotion' => [
            'class' => 'app\modules\promotion\Module',
        ],
        'cdek' => [
            'class' => 'app\modules\cdek\Module',
        ],
        'media' => [
            'class' => 'app\modules\media\Module',
        ],
        'acquiring' => [
            'class' => 'app\modules\acquiring\Module',
        ],
        'cdn' => [
            'class' => 'app\modules\cdn\Module',
        ],
        'mercury' => [
            'class' => 'app\modules\mercury\Module',
        ],
        'reviews' => [
            'class' => 'app\modules\reviews\Module',
        ],
        'mailer' => [
            'class' => 'app\modules\mailer\Module',
        ],
    ],

];


$config['components']['mailer'] = [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => false,
    'enableSwiftMailerLogging' => true,
    'viewPath' => '@app/mail',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.timeweb.ru',
        'username' => 'sale@kotofey.store',
        'password' => '123qweR%',
        'port' => '465',
        'encryption' => 'ssl',
    ],
    // send all mails to a file by default. You have to set
    // 'useFileTransport' to false and configure a transport
    // for the mailer to send real emails.
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
