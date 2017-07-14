<?php

require __DIR__ . '/prod.php';

// Debug
$app['debug'] = true;

// Log
$app['log.level'] = Monolog\Logger::ERROR;
error_reporting( E_ALL );

// API
$app['api.endpoint'] = '';
$app['api.version']  = 'v1.0';