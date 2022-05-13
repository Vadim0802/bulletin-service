<?php

namespace Bodianskii\BulletinService\Kernel;

use Laminas\Diactoros\ServerRequestFactory;
use League\Route\Router;
use Psr\Http\Message\ServerRequestInterface;

class RequestHandler
{
    public Router $router;
    public ServerRequestInterface $request;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->request = ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );
    }

    public function handle()
    {
        return $this->router->dispatch($this->request);
    }
}