<?php
/** OCI 8 DB
return [
    'class' => 'neconix\yii2oci8\Oci8Connection',
    'dsn' => '',
    'username' => '',
    'password' => '',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60 * 60,
    'attributes' => [PDO::ATTR_PERSISTENT => true],
];
**/

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
