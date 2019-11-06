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
			'identityClass' => 'app\models\entity\User',
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
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
//            'useFileTransport' => true,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
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
				'gii' => 'gii',
				'support/<category[a-z-\/\d]+>/<id[a-z-\/\d]+>' => 'site/support',
				'<controller:(admin|ajax|apivk)>/' => '<controller>/index',
				'<controller:(admin|ajax|apivk)>' => '<controller>/<action>',
				'<controller:(admin|ajax|apivk)>/<action>' => '<controller>/<action>',
				'<controller:(admin|ajax|apivk)>/<action>/<id[a-zA-Z-\/\d]+>' => '<controller>/<action>',
				'<action>' => 'site/<action>',
				'<action>/<id[a-z-\/\d]+>' => 'site/<action>',
			]
		],
	],
	'params' => $params,
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ['127.0.0.1', '::1', '109.195.36.227', '5.166.94.197'],
	];

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		// uncomment the following to add your IP if you are not connecting from localhost.
		'allowedIPs' => ['127.0.0.1', '::1', '109.195.36.227', '5.166.94.197'],
	];
}

return $config;
