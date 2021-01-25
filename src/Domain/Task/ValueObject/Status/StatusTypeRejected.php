<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Status;

use App\Domain\Task\ValueObject\Status;

class StatusTypeRejected extends Status
{
    public function getValue(): int
    {
        return StatusTypes::REJECTED;
    }

    public function getLabel(): string
    {
        return 'Backlog';
    }
}
