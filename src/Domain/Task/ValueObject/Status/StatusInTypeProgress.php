<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Status;

use App\Domain\Task\ValueObject\Status;

class StatusInTypeProgress extends Status
{
    public function getValue(): int
    {
        return StatusTypes::IN_PROGRESS;
    }

    public function getLabel(): string
    {
        return 'InProgress';
    }
}
