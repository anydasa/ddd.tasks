<?php

declare(strict_types=1);

namespace App\Application\Query\Task\GetTask;

use App\Application\QueryHandlerInterface;
use App\Domain\Task\Repository\TaskReadRepositoryInterface;
use App\Domain\Task\View\TaskViewInterface;

class GetTaskByIdHandler implements QueryHandlerInterface
{
    private TaskReadRepositoryInterface $repository;

    public function __construct(TaskReadRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetTaskByIdQuery $query): TaskViewInterface
    {
        return $this->repository->oneById($query->getId());
    }
}
