<?php

namespace Bodianskii\BulletinService\Controllers;

use Bodianskii\BulletinService\Models\Bulletin;
use Carbon\Carbon;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;

class BulletinController
{
    public static function index(): ResponseInterface
    {
        $bulletins = Bulletin::all()->toJson();

        $response = new Response();
        $response->getBody()->write($bulletins);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function show()
    {

    }

    public static function store()
    {

    }
}