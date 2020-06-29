<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
//					'google' => [
//						'class' => 'yii\authclient\clients\GoogleOpenId'
//					],
//					'facebook' => [
//						'class' => 'yii\authclient\clients\Facebook',
//						'clientId' => 'facebook_client_id',
//						'clientSecret' => 'секретный_ключ_facebook_client',
//					],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '7209302',
                    'clientSecret' => 'FxeKQQ5slF3iXqhanR4c',
                ],
            ],
        ],
        'socialShare' => [
            'class' => \ymaker\social\share\configurators\Configurator::class,
            'enableDefaultIcons' => true,
            'socialNetworks' => [
                'vkontakte' => [
                    'class' => \ymaker\social\share\drivers\Vkontakte::class,
                ],
                'facebook' => [
                    'class' => \ymaker\social\share\drivers\Facebook::class,
                ],
                'odnoklasniki' => [
                    'class' => \ymaker\social\share\drivers\Odnoklassniki::class,
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'o47rMjhQ6Rk50sxHSuLaEput3lsfchPR',
            'baseUrl' => '',
//            'baseUrl' => str_replace('/web', '', (new \yii\web\Request)->getBaseUrl()),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\entity\User',
            'loginUrl' => ['site/signin'],
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'enableSwiftMailerLogging' => true,
            'viewPath' => '@app/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.timeweb.ru',
                'username' => 'sale@kotofey.store',
                'password' => '123qweR%',
//				'port' => '465',
//				'encryption' => 'tls',
            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'categories' => ['yii\swiftmailer\Logger::add'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'suffix' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'order' => 'order/order/index',
                'admin/<module>/<controller>/' => '<module>/<controller>/index',
                'admin/<module>/<controller>/<action>' => '<module>/<controller>/<action>',
                'bot/vk/index' => 'bot/vk/index',
                'rest/product/create' => 'rest/product/create',
                'rest/product/get/<id:(\d+)>' => 'rest/product/get',
                'rest/category/three' => 'rest/category/three',
                'market' => 'yandex/catalog/export',
                'gii' => 'gii',
                'support/<category[a-z-\/\d]+>/<id[a-z-\/\d]+>' => 'site/support',
                '<controller:(admin|ajax)>/' => '<controller>/index',
                '<controller:(admin|ajax)>' => '<controller>/<action>',
                '<controller:ajax>/<action>/<product_id:\d+>' => '<controller>/<action>',
                '<controller:ajax>/<action>/<product_id:\d+>/<count:\d+>' => '<controller>/<action>',
                '<controller:(admin|ajax)>/<action>' => '<controller>/<action>',
                '<controller:(admin|ajax)>/<action>/<id[0-9a-zA-Z-]+>' => '<controller>/<action>',
                '<action>' => 'site/<action>',
                '<action>/<id[A-Za-z-\/\d_]+>' => 'site/<action>',
            ]
        ],
    ],
    'modules' => [
        'promo' => [
            'class' => 'app\modules\promo\Module',
        ],
        'yandex' => [
            'class' => 'app\modules\yandex\Module',
        ],
        'rest' => [
            'class' => 'app\modules\rest\Module',
        ],
        'bot' => [
            'class' => 'app\modules\bot\Module',
        ],
        'catalog' => [
            'class' => 'app\modules\catalog\Module',
        ],
        'feed' => [
            'class' => 'app\modules\feed\Module',
        ],
        'order' => [
            'class' => 'app\modules\order\Module',
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
        'settings' => [
            'class' => 'app\modules\settings\Module',
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
    ],
    'params' => $params,
];

if (YII_ENV_DEV or $_SERVER['REMOTE_ADDR'] == '109.171.61.86') {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '109.195.36.227', '5.166.94.197', '109.171.61.86'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '109.195.36.227', '5.166.94.197'],
    ];
}

return $config;
