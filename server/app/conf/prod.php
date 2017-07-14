<?php

// Default timezone
date_default_timezone_set( 'Europe/Paris' );

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => '127.0.0.1',
    'port'     => '3306',
    'dbname'   => 'erasiamanager',
    'user'     => 'em_user',
    'password' => '***',
);