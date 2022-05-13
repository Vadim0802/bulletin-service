<?php

namespace Bodianskii\BulletinService\Controllers;

use Bodianskii\BulletinService\Models\Bulletin;
use Bodianskii\BulletinService\Utils\Paginator;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BulletinController
{
    public static function index(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();

        $paginator = new Paginator($params['page'], Bulletin::class);

        $bulletins = $paginator->paginate()->map(fn ($bulletin) => [
            'id' => $bulletin->id,
            'title' => $bulletin->title,
            'price' => $bulletin->price,
            'picture' => $bulletin->images->first()->only('path')
        ]);

        $json = collect([
            'data' => $bulletins,
            'meta' => $paginator->meta()
        ]);

        $response = new Response();
        $response->getBody()->write($json->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function show(ServerRequestInterface $request, $params): ResponseInterface
    {

    }

    public static function store()
    {

    }
}