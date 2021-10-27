<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=mariadb;port=3361;dbname=demo_site;',
    'username' => 'demo_site',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600 * 24 * 7,
    'schemaCache' => 'cache',
];