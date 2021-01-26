<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Priority;

use App\Domain\Task\ValueObject\Priority;

class PriorityHigh extends Priority
{
    public function getValue(): int
    {
        return PriorityTypes::VALUE_HIGH;
    }

    public function getLabel(): string
    {
        return 'High';
    }
}
