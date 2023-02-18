<?php

use Sooky\DatabaseImport\classes\Application;
use Sooky\DatabaseImport\classes\Database;

require_once __DIR__ . '/vendor/autoload.php';
$db_config = require_once __DIR__ . '/src/config/db.php';

$db = Database::getInstance($db_config);
$app = new Application($db);

$app->initDatabase();
//$app->dropDatabase();