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
    public const VALUE_LOW = 10;
    public const VALUE_MEDIUM = 20;
    public const VALUE_HIGH = 30;

    public const CODE_LOW = 'low';
    public const CODE_MEDIUM = 'medium';
    public const CODE_HIGH = 'high';
    
    public const VALUE_CODE_MAP = [
        self::VALUE_LOW => self::CODE_LOW,
        self::VALUE_MEDIUM => self::CODE_MEDIUM,
        self::VALUE_HIGH => self::CODE_HIGH,
    ];

    private function __construct()
    {
    }
}
