<?php

use League\Route\Router;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

\Bodianskii\BulletinService\Database\DatabaseManager::initial();

$commandHandler = new \Bodianskii\BulletinService\Commands\CommandHandler();
$commandHandler->handle($argv[1]);
