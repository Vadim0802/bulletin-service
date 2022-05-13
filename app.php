<?php

use Bodianskii\BulletinService\Commands\CommandHandler;
use Bodianskii\BulletinService\Database\DatabaseManager;
use Dotenv\Dotenv;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

DatabaseManager::initial();

$commandHandler = new CommandHandler();
$commandHandler->handle($argv[1]);
