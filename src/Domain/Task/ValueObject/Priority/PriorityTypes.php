<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject\Priority;

use App\Domain\Common\Exception\CannotCreateEntityException;
use App\Domain\Task\ValueObject\Status\StatusInTypeProgress;
use App\Domain\Task\ValueObject\Status\StatusTypeBacklog;
use App\Domain\Task\ValueObject\Status\StatusTypeDone;
use App\Domain\Task\ValueObject\Status\StatusTypePaused;
use App\Domain\Task\ValueObject\Status\StatusTypeRejected;
use App\Domain\Task\ValueObject\Status\StatusTypes;
use App\Domain\Task\ValueObject\Status\StatusTypeTodo;

final class PriorityTypes
{
    public const LOW = 10;
    public const MEDIUM = 20;
    public const HIGH = 30;

    private function __construct()
    {
    }
}
