<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Status;

final class StatusTypes
{
    public const BACKLOG = 0;
    public const TODO = 1;
    public const IN_PROGRESS = 2;
    public const PAUSED = 3;
    public const DONE = 4;
    public const REJECTED = 5;

    private function __construct()
    {
    }
}
