<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Status;
use App\Domain\Task\ValueObject\Status;

class StatusTypeDone extends Status
{
    public function getValue(): int
    {
        return StatusTypes::DONE;
    }

    public function getLabel(): string
    {
        return 'Done';
    }
}
