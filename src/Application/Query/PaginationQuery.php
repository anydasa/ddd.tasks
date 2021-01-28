<?php

declare(strict_types=1);

namespace App\Application\Query;

class PaginationQuery
{
    protected int $page;

    protected int $pageSize;

    public function __construct(int $page, int $pageSize)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}
