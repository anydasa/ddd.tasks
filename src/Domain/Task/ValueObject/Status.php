<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

use App\Domain\Task\ValueObject\Status\StatusInTypeProgress;
use App\Domain\Task\ValueObject\Status\StatusTypeBacklog;
use App\Domain\Task\ValueObject\Status\StatusTypeDone;
use App\Domain\Task\ValueObject\Status\StatusTypePaused;
use App\Domain\Task\ValueObject\Status\StatusTypeRejected;
use App\Domain\Task\ValueObject\Status\StatusTypes;
use App\Domain\Task\ValueObject\Status\StatusTypeTodo;
use Assert\Assertion;

abstract class Status
{
    private const BUILTIN_TYPES_MAP = [
        StatusTypes::BACKLOG => StatusTypeBacklog::class,
        StatusTypes::TODO => StatusTypeTodo::class,
        StatusTypes::IN_PROGRESS => StatusInTypeProgress::class,
        StatusTypes::PAUSED => StatusTypePaused::class,
        StatusTypes::DONE => StatusTypeDone::class,
        StatusTypes::REJECTED => StatusTypeRejected::class,
    ];

    abstract public function getValue(): int;

    abstract public function getLabel(): string;

    public static function createFromValue(int $value): Status
    {
        Assertion::keyExists(self::BUILTIN_TYPES_MAP, $value, 'Not allowed status type');

        $class = self::BUILTIN_TYPES_MAP[$value];

        return new $class();
    }
}
