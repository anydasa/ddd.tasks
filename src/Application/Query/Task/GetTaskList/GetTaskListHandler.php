<?php

declare(strict_types=1);

namespace App\Application\Query\Task\GetTaskList;

use App\Application\QueryHandlerInterface;
use App\Domain\Task\Repository\TaskReadRepositoryInterface;

class GetTaskListHandler implements QueryHandlerInterface
{
    private TaskReadRepositoryInterface $readRepository;

    public function __construct(TaskReadRepositoryInterface $readRepository)
    {
        $this->readRepository = $readRepository;
    }

    public function handle(GetTaskListQuery $query)
    {
        return $this->readRepository->allByCriteria($query->getFilter(), $query->getPageSize(), $query->getPage());
    }
}
