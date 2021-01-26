<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Priority;

use App\Domain\Task\ValueObject\Priority;

class PriorityMedium extends Priority
{
    public function getValue(): int
    {
        return PriorityTypes::VALUE_MEDIUM;
    }

    public function getLabel(): string
    {
        return 'Medium';
    }
}

