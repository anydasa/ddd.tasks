<?php

declare(strict_types=1);

namespace App\Application\Command\Task\EditTask;

use App\Application\CommandHandlerInterface;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\ValueObject\Description;
use App\Domain\Task\ValueObject\DueDate;
use App\Domain\Task\ValueObject\Label;
use App\Domain\Task\ValueObject\Priority;
use App\Domain\Task\ValueObject\TaskId;

class EditTaskHandler implements CommandHandlerInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(EditTaskCommand $command)
    {
        $task = $this->taskRepository->getById(new TaskId($command->getId()));

        $task->changeDetails(
            new Label($command->getLabel()),
            new Description($command->getDescription())
        );

        $task->changeDueDate(new DueDate($command->getDueDate()));
        $task->changePriority(Priority::createFromCode($command->getPriority()));

        $this->taskRepository->flush();
    }
}
