<?php

$env = getenv();

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=kitchen;dbname=demo',
    'username' => $env['MYSQL_USER'] ?? 'root',
    'password' => $env['MYSQL_PASSWORD'] ?? '1234',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
