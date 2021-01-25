<?php

declare(strict_types=1);

namespace App\Infrastructure\Common;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ViewModelCollection.
 */
class ViewModelList extends ArrayCollection
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
     * @var int
     */
    protected $totalCount;

    /**
     * ViewModelCollection constructor.
     */
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
