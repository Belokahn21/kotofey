<?php


switch (YII_ENV) {
    case'prod':
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
        break;
    case'dev':
        return [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=kotofey_shop',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',

            // Schema cache options (for production environment)
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ];
        break;
}