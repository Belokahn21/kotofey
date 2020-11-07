<?php
if (YII_ENV == 'test') {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=172.16.101.22;dbname=kot_test',
        'username' => 'kot_test',
        'password' => '985236544as',
        'charset' => 'utf8',

        // Schema cache options (for production environment)
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 3600 * 24 * 7,
        'schemaCache' => 'cache',
    ];
}
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=kotofey_store',
    'username' => 'kotofey',
    'password' => '123qweR%',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600 * 24 * 7,
    'schemaCache' => 'cache',
];