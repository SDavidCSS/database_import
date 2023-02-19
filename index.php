<?php

use Sooky\DatabaseImport\classes\Application;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = require_once __DIR__ . '/src/config/config.php';
$app = new Application($config);

//$app->initDatabase();
$app->import();
//$app->dropDatabase();