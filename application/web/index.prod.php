<?php
// comment out the following two lines when deployed to production
if (in_array($_SERVER['REMOTE_ADDR'], ['109.171.61.86', '176.212.127.47'])) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
} else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
}
defined('YII_ENV') or define('YII_ENV', 'prod');
if (!ini_get('date.timezone')) {
    date_default_timezone_set('Asia/Barnaul');
}
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/web.php';
(new yii\web\Application($config))->run();