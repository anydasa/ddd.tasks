<?php

declare(strict_types=1);

namespace App\Application\Query\Task\GetTaskCollection;

use App\Application\QueryHandlerInterface;
use App\Domain\Task\Repository\TaskReadModelRepositoryInterface;

/**
 * Class GetFormCollectionHandler.
 */
class GetFormCollectionHandler implements QueryHandlerInterface
{
    /**
     * @var TaskReadModelRepositoryInterface
     */
    private $formReadModelRepository;

    /**
     * GetFormCollectionHandler constructor.
     */
    public function __construct(TaskReadModelRepositoryInterface $formReadModelRepository)
    {
        $this->formReadModelRepository = $formReadModelRepository;
    }

    /**
     * @return mixed
     */
    public function handle(GetTaskCollectionQuery $query)
    {
        return $this->formReadModelRepository->allByCriteria($query->getFilter(), $query->getPageSize(), $query->getPage());
    }
}
