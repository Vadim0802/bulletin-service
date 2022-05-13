<?php

use Bodianskii\BulletinService\Kernel\RequestHandler;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use League\Route\Router;
use function Bodianskii\BulletinService\Routes\defineRoutes;

require_once __DIR__ . '/../app.php';

$router = new Router();
defineRoutes($router);

$requestHandler = new RequestHandler($router);
$response = $requestHandler->handle();
(new SapiEmitter())->emit($response);