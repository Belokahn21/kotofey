<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mariadb;port=3361;dbname=kotofey;',
    'username' => 'kotofey',
    'password' => '123qweR%',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600 * 24 * 7,
    'schemaCache' => 'cache',
];