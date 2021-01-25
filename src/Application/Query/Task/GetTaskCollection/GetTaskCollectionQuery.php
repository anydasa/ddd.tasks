<?php

declare(strict_types=1);

namespace App\Application\Query\Task\GetTaskCollection;

use App\Application\Query\PaginationQuery;

/**
 * Class GetFormCollectionQuery.
 */
class GetTaskCollectionQuery extends PaginationQuery
{
    /**
     * @var array
     */
    protected $filter = [];

    /**
     * PaginationQuery constructor.
     */
    public function __construct(array $filter, int $page, int $pageSize)
    {
        $this->filter = $filter;

        parent::__construct($page, $pageSize);
    }

    public function getFilter(): array
    {
        return $this->filter;
    }
}
