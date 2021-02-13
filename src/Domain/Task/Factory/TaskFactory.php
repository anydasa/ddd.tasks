<?php

namespace App\Domain\Task\Factory;

use App\Domain\Task\Task;
use App\Domain\Task\ValueObject\Description;
use App\Domain\Task\ValueObject\DueDate;
use App\Domain\Task\ValueObject\Label;
use App\Domain\Task\ValueObject\Priority;
use App\Domain\Task\ValueObject\Status;
use App\Domain\Task\ValueObject\TaskId;

class TaskFactory
{
    public static function createNew(TaskId $taskId, Label $label, Description $description, Priority $priority, DueDate $dueDate): Task
    {
        return Task::create(
            $taskId,
            $label,
            $description,
            Status::createFromValue(Status\StatusTypes::BACKLOG),
            $priority,
            $dueDate
        );
    }
}
