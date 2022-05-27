<?php

namespace Bodianskii\BulletinService\Resources;

use Bodianskii\BulletinService\Utils\Link;

class BulletinResource
{
    private array $resource;

    public function __construct($bulletin, array $optionalFields)
    {
        $this->resource = [
            'id' => $bulletin->id,
            'price' => $bulletin->price,
            'picture' => Link::build($bulletin->images->first()->path),
        ];

        if (in_array('images', $optionalFields)) {
            $this->resource['images'] = $bulletin->images
                ->map(fn ($image) => Link::build($image->path))
                ->filter(fn ($imageLink) => $imageLink !== $this->resource['picture'])->values();
        }

        if (in_array('description', $optionalFields)) {
            $this->resource['description'] = $bulletin->description;
        }
    }

    public function toJson(): string
    {
        return json_encode($this->resource);
    }
}