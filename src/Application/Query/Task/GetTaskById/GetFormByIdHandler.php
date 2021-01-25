<?php

declare(strict_types=1);

namespace App\Application\Query\Task\GetTaskById;

use App\Application\QueryHandlerInterface;
use App\Domain\Task\Repository\TaskReadModelRepositoryInterface;
use App\Domain\Task\View\TaskViewInterface;

/**
 * Class GetFormByIdHandler.
 */
class GetFormByIdHandler implements QueryHandlerInterface
{
    /**
     * @var TaskReadModelRepositoryInterface
     */
    private TaskReadModelRepositoryInterface $formReadRepository;

    /**
     * GetFormByIdHandler constructor.
     * @param TaskReadModelRepositoryInterface $formReadRepository
     */
    public function __construct(TaskReadModelRepositoryInterface $formReadRepository)
    {
        $this->formReadRepository = $formReadRepository;
    }

    /**
     * @param GetFormByIdQuery $query
     * @return TaskViewInterface
     */
    public function handle(GetFormByIdQuery $query): TaskViewInterface
    {
        return $this->formReadRepository->oneWithRelatedById($query->getId());
    }
}
