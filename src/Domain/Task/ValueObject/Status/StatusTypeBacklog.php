<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Status;

use App\Domain\Task\ValueObject\Status;

class StatusTypeBacklog extends Status
{
    public function getValue(): int
    {
        return StatusTypes::BACKLOG;
    }

    public function getLabel(): string
    {
        return 'Backlog';
    }
}
