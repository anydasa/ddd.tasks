<?php

declare(strict_types=1);

namespace App\Domain\Task\Repository;

use App\Domain\Task\Model\Task;
use App\Domain\Task\ValueObject\TaskId;

interface TaskRepositoryInterface
{
    public function add(Task $task): void;

    public function getById(TaskId $id): Task;

    public function remove(Task $task): void;

    public function flush(): void;
}
