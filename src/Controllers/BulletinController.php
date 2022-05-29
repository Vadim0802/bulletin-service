<?php

namespace Bodianskii\BulletinService\Controllers;

use Bodianskii\BulletinService\Models\Bulletin;
use Bodianskii\BulletinService\Resources\BulletinResource;
use Bodianskii\BulletinService\Resources\BulletinResourceCollection;
use Bodianskii\BulletinService\Services\UploadImageService;
use Bodianskii\BulletinService\Utils\Paginator;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BulletinController
{
    private UploadImageService $uploadImageService;

    public function __construct()
    {
        $this->uploadImageService = new UploadImageService();
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        /** @var integer|null $page */
        ['page' => $page, 'sort' => $sort] = array_merge([
            'sort' => [
                'field' => 'id',
                'direction' => 'asc'
            ]
        ], $request->getQueryParams());

        $response = new Response();
        $paginator = new Paginator($page, Bulletin::query()->count());

        $bulletins = $paginator->paginate(Bulletin::query()->orderBy($sort['field'], $sort['direction']));

        if ($bulletins->isEmpty()) {
            return $response->withStatus(404);
        }

        $bulletinsResource = new BulletinResourceCollection($bulletins);
        $bulletinsResource->insertMetaData($paginator->meta());

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

    public function store(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        if (! $this->validateStoreRequest($request)) {
            $response->getBody()->write(json_encode([
                'status' => 'failed',
                'message' => 'Validation failed.',
            ]));
            return $response->withStatus(400);
        }

        $bulletin = Bulletin::query()->create(array_merge($request->getParsedBody(), [
            'created_at' => date("Y-m-d H:i:s")
        ]));

        $this->uploadImageService->store($bulletin, $_FILES['images']['tmp_name']);

        $response->getBody()->write(json_encode([
            'data' => ['id' => $bulletin->id],
            'status' => 'success'
        ]));

        return $response->withStatus(201);
    }

    public function validateStoreRequest(ServerRequestInterface $request): bool
    {
        $body = $request->getParsedBody();

        $validateAllFieldsExist = isset($body['description']) && isset($body['title']) &&
            isset($body['price']) && isset($_FILES['images']);

        $validateLengthOfFields = strlen($body['title']) <= 200 && strlen($body['description']) <= 2000;
        $validateCountOfImages = count($_FILES['images']['name'] ?? []) <= 3;
        $validateFilesExtension = $this->uploadImageService->validate($_FILES['images']['tmp_name']);

        return $validateAllFieldsExist && $validateLengthOfFields && $validateCountOfImages && $validateFilesExtension;
    }
}
