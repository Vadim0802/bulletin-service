<?php

namespace Bodianskii\BulletinService\Controllers;

use Bodianskii\BulletinService\Models\Bulletin;
use Bodianskii\BulletinService\Resources\BulletinResource;
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
        $response = new Response();
        $queryParams = $request->getQueryParams();

        if (! $bulletin = Bulletin::query()->find($params['id'])) {
            return $response->withStatus(404);
        }

        $optionalFields = $queryParams['fields'] ?? [];
        $bulletinResource = new BulletinResource($bulletin, $optionalFields);

        $response->getBody()->write($bulletinResource->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function store(ServerRequestInterface $request)
    {
        $response = new Response();
        $body = $request->getParsedBody();

        if (!(
            isset($body['description']) &&
            isset($body['title']) &&
            isset($body['price']) &&
            isset($_FILES['images'])) ||
            (strlen($body['title']) > 200 || strlen($body['description']) > 2000) ||
            (count($_FILES['images']['name']) > 3)
        ) {
            $response->getBody()->write(json_encode([
                'status' => 'failed',
                'message' => 'Validation failed.',
            ]));
            return $response->withStatus(400);
        }

        $bulletin = Bulletin::query()->create([
            'title' => $body['title'],
            'price' => $body['price'],
            'description' => $body['description'],
            'created_at' => date("Y-m-d H:i:s")
        ]);

        $response->getBody()->write(json_encode([
            'data' => ['id' => $bulletin->id],
            'status' => 'success'
        ]));
        return $response->withStatus(201);
    }
}