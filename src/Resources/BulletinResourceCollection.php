<?php

namespace Bodianskii\BulletinService\Resources;

use Bodianskii\BulletinService\Utils\Link;
use Illuminate\Support\Collection;

class BulletinResourceCollection
{
    private Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = collect([]);
        $this->collection->add([
            'data' => $collection->map(fn ($bulletin) => [
                'id' => $bulletin->id,
                'title' => $bulletin->title,
                'price' => $bulletin->price,
                'picture' => Link::build($bulletin->images->first()->path)
            ])
        ]);
    }

    public function insertMetaData(Collection $meta): void
    {
        $this->collection->add([
            'meta' => $meta
        ]);
    }

    public function toJson(): string
    {
        return $this->collection->toJson();
    }
}