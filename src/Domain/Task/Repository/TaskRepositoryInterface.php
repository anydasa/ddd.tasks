<?php

declare(strict_types=1);

namespace App\Domain\Task\Repository;

use App\Domain\Task\Task;
use App\Domain\Task\ValueObject\TaskId;

interface TaskRepositoryInterface
{
    public function store(Task $task): void;

    public function getById(TaskId $id): Task;

    public function remove(Task $task): void;
}
