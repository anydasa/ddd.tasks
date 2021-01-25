<?php

declare(strict_types=1);

namespace App\Application\Command\Task\CreateTask;

use App\Application\CommandHandlerInterface;
use App\Domain\Task\Factory\TaskFactory;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\ValueObject\Description;
use App\Domain\Task\ValueObject\DueDate;
use App\Domain\Task\ValueObject\Label;
use App\Domain\Task\ValueObject\Priority;
use App\Domain\Task\ValueObject\TaskId;

class CreateTaskHandler implements CommandHandlerInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(CreateTaskCommand $command): void
    {
        $task = TaskFactory::createNew(
            new TaskId($command->getId()),
            new Label($command->getLabel()),
            new Description($command->getDescription()),
            Priority::createFromValue($command->getPriority()),
            new DueDate($command->getDueDate())
        );

        $this->taskRepository->add($task);
        $this->taskRepository->flush();
    }
}
