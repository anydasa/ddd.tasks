<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Status;

use App\Domain\Task\ValueObject\Status;

class StatusTypePaused extends Status
{
    public function getValue(): int
    {
        return StatusTypes::PAUSED;
    }

    public function getLabel(): string
    {
        return 'Paused';
    }
}
