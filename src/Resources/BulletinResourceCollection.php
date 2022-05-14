<?php

namespace Bodianskii\BulletinService\Resources;

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
                'picture' => $bulletin->images->first()->only('path')
            ])
        ]);
    }

    public function insertMetaData(Collection $meta)
    {
        $this->collection->add([
            'meta' => $meta
        ]);
    }

    public function toJson()
    {
        return $this->collection->toJson();
    }
}