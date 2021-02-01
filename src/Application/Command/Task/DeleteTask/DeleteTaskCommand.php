<?php

declare(strict_types=1);

namespace App\Application\Command\Task\DeleteTask;

use App\Domain\Task\ValueObject\TaskId;

class DeleteTaskCommand
{
    private TaskId $id;

    public function __construct(string $id)
    {
        $this->id = new TaskId($id);
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}
