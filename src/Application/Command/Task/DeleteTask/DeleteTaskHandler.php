<?php

declare(strict_types=1);

namespace App\Application\Command\Task\DeleteTask;

use App\Application\CommandHandlerInterface;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\ValueObject\TaskId;

class DeleteTaskHandler implements CommandHandlerInterface
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle(DeleteTaskCommand $command)
    {
        $task = $this->taskRepository->getById(new TaskId($command->getId()));
        $this->taskRepository->remove($task);
        $this->taskRepository->flush();
    }
}
