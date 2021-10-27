<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mariadb;dbname=kotofey;port=33061',
    'username' => 'kotofey',
    'password' => '123qweR%',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600 * 24 * 7,
    'schemaCache' => 'cache',
];