<?
if ($_SERVER['SERVER_NAME'] == "" or $_SERVER['SERVER_NAME'] == "kotofey.store") {    // timeweb
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=cd91333_kotofey',
        'username' => 'cd91333_kotofey',
        'password' => '123qweR%',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 60,
        'schemaCache' => 'cache',
    ];
} elseif ($_SERVER['SERVER_NAME'] == "local.leather.ru") {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=leather_shop_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 60,
        'schemaCache' => 'cache',
    ];
}