<?php

namespace Bodianskii\BulletinService\Utils;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Paginator
{
    private int $perPage;
    private int $totalCount;
    private int $currentPage;
    private int $lastPage;

    public function __construct(?int $page, int $totalCount, int $perPage = 10)
    {
        $this->perPage = $perPage;
        $this->totalCount = $totalCount;
        $this->currentPage = $page ?? 1;
        $this->lastPage = ceil($totalCount / $perPage);
    }

    public function paginate(Builder $query): Collection
    {
        $offset = $this->currentPage * $this->perPage - $this->perPage;
        return $query->offset($offset)->limit($this->perPage)->get();
    }

    public function meta(): Collection
    {
        return collect([
            'page' => $this->currentPage,
            'last' => $this->lastPage,
            'next' => $this->hasNextPage() ? $this->currentPage + 1 : null,
            'prev' => $this->hasPreviousPage() ? $this->currentPage - 1 : null
        ]);
    }

    private function hasNextPage()
    {
        $offset = ($this->currentPage + 1) * $this->perPage - $this->perPage;
        return $offset < $this->totalCount;
    }

    private function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }
}