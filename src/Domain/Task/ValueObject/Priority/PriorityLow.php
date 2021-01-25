<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Priority;

use App\Domain\Task\ValueObject\Priority;

class PriorityLow extends Priority
{
    public function getValue(): int
    {
        return PriorityTypes::LOW;
    }

    public function getLabel(): string
    {
        return 'Low';
    }
}
