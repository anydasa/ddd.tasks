<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

use App\Domain\Common\Exception\CannotCreateEntityException;
use App\Domain\Task\ValueObject\Priority\PriorityHigh;
use App\Domain\Task\ValueObject\Priority\PriorityLow;
use App\Domain\Task\ValueObject\Priority\PriorityMedium;
use App\Domain\Task\ValueObject\Priority\PriorityTypes;

abstract class Priority
{
    private const BUILTIN_TYPES_MAP = [
        PriorityTypes::LOW => PriorityLow::class,
        PriorityTypes::MEDIUM => PriorityMedium::class,
        PriorityTypes::HIGH => PriorityHigh::class,
    ];

    abstract public function getValue(): int;

    abstract public function getLabel(): string;

    public static function createFromValue(int $value): Priority
    {
        if (array_key_exists($value, self::BUILTIN_TYPES_MAP)) {
            $class = self::BUILTIN_TYPES_MAP[$value];

            return new $class();
        }

        throw new CannotCreateEntityException(sprintf("Can't create priority from value: %s", $value));
    }
}
