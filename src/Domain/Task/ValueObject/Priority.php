<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

use App\Domain\Task\ValueObject\Priority\PriorityHigh;
use App\Domain\Task\ValueObject\Priority\PriorityLow;
use App\Domain\Task\ValueObject\Priority\PriorityMedium;
use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use Assert\Assertion;

abstract class Priority
{
    private const BUILTIN_TYPES_VALUE_MAP = [
        PriorityTypes::VALUE_LOW => PriorityLow::class,
        PriorityTypes::VALUE_MEDIUM => PriorityMedium::class,
        PriorityTypes::VALUE_HIGH => PriorityHigh::class,
    ];

    private const BUILTIN_TYPES_CODE_MAP = [
        PriorityTypes::CODE_LOW => PriorityLow::class,
        PriorityTypes::CODE_MEDIUM => PriorityMedium::class,
        PriorityTypes::CODE_HIGH => PriorityHigh::class,
    ];

    abstract public function getValue(): int;

    abstract public function getLabel(): string;

    public static function createFromValue(int $value): Priority
    {
        Assertion::keyExists(self::BUILTIN_TYPES_VALUE_MAP, $value, 'Not allowed priority type');

        $class = self::BUILTIN_TYPES_VALUE_MAP[$value];

        return new $class();
    }

    public static function createFromCode(string $value): Priority
    {
        Assertion::keyExists(self::BUILTIN_TYPES_CODE_MAP, $value, 'Not allowed priority type');

        $class = self::BUILTIN_TYPES_CODE_MAP[$value];

        return new $class();
    }

    public function equal(Priority $other): bool
    {
        return $other->getValue() === $this->getValue();
    }
}
