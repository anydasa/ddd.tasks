<?php

declare(strict_types=1);

namespace App\Application\Query;

/**
 * Class PaginationQuery.
 */
class PaginationQuery
{
    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $pageSize;

    /**
     * PaginationQuery constructor.
     */
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
