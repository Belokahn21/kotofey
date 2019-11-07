<?php
if (YII_ENV == 'prod' and empty($_SERVER['DOCUMENT_ROOT'])) {
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
}
if (YII_ENV == 'dev' and empty($_SERVER['DOCUMENT_ROOT'])) {
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
}