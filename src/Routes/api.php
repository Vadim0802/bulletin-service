<?php

namespace Bodianskii\BulletinService\Routes;

use League\Route\Router;

function defineRoutes(Router $router): void
{
    $router->get('/bulletins', '\Bodianskii\BulletinService\Controllers\BulletinController::index');
}