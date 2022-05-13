<?php

namespace Bodianskii\BulletinService\Utils;

use Illuminate\Support\Collection;

class Paginator
{
    private int $currentPage;
    private int $perPage;
    private string $model;

    public function __construct(?int $page, string $model, int $perPage = 10)
    {
        $this->currentPage = $page ?? 0;
        $this->perPage = $perPage;
        $this->model = $model;
    }

    public function paginate(): Collection
    {
        $offset = $this->currentPage * $this->perPage - $this->perPage;
        return $this->model::query()->offset($offset)->limit($this->perPage)->get();
    }

    public function meta(): Collection
    {
        $hasNext = $this->hasNextPage();
        $hasPrev = $this->hasPrevPage();

        return collect([
            'page' => $this->currentPage,
            'next' => $hasNext ? $this->currentPage + 1 : null,
            'prev' => $hasPrev ? $this->currentPage - 1 : null
        ]);
    }

    private function hasNextPage()
    {
        $offset = ($this->currentPage + 1) * $this->perPage - $this->perPage;
        return empty($this->model::query()->offset($offset)->limit(1)->get());
    }

    private function hasPrevPage()
    {
        return $this->currentPage !== 0;
    }
}