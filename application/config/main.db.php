<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=' . $_ENV['DB_NAME'],
    'username' => $_ENV['DB_LOGIN'],
    'password' => $_ENV['DB_PWD'],
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600 * 24 * 7,
    'schemaCache' => 'cache',
];