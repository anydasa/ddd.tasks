<?php

declare(strict_types=1);

namespace App\Infrastructure\Common;

use Doctrine\Common\Collections\ArrayCollection;

class ListView extends ArrayCollection
{
    protected int $page;

    protected int $pageSize;

    protected int $totalCount;

    public function __construct(array $elements = [], int $page, int $pageSize, int $totalCount)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->totalCount = $totalCount;

        parent::__construct($elements);
    }

    public function getMeta(): array
    {
        return [
            'totalCount' => $this->totalCount,
            'pageSize' => $this->pageSize,
            'page' => $this->page,
        ];
    }
}
