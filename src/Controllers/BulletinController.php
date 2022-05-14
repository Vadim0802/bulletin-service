<?php

namespace Bodianskii\BulletinService\Controllers;

use Bodianskii\BulletinService\Models\Bulletin;
use Bodianskii\BulletinService\Resources\BulletinResourceCollection;
use Bodianskii\BulletinService\Utils\Paginator;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BulletinController
{
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        $defaultQueryParams = [
            'page' => 1,
            'sort' => [
                'field' => 'id',
                'direction' => 'asc'
            ]
        ];

        [
            'page' => $page,
            'sort' => $sort
        ] = array_merge($defaultQueryParams, $request->getQueryParams());

        $paginator = new Paginator($page, Bulletin::query()->count());

        $bulletins = Bulletin::query()->orderBy($sort['field'], $sort['direction']);
        $bulletinsResource = new BulletinResourceCollection($paginator->paginate($bulletins));
        $bulletinsResource->insertMetaData($paginator->meta());

        $response = new Response();
        $response->getBody()->write($bulletinsResource->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function show(ServerRequestInterface $request, $params): ResponseInterface
    {

    }

    public function store()
    {

    }
}