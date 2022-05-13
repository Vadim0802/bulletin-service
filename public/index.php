<?php

require_once __DIR__ . '/../app.php';

$router = new \League\Route\Router();
\Bodianskii\BulletinService\Routes\defineRoutes($router);

$requestHandler = new \Bodianskii\BulletinService\Kernel\RequestHandler($router);
$response = $requestHandler->handle();
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);