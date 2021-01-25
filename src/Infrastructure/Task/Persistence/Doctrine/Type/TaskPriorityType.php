<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\Doctrine\Type;

use App\Domain\Task\ValueObject\Priority;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\IntegerType;

class TaskPriorityType extends IntegerType
{
    const TASK_PRIORITY = 'taskPriority';

    public function getName(): string
    {
        return self::TASK_PRIORITY;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Priority
    {
        return Priority::createFromValue($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        if ($value instanceof Priority) {
            return $value->getValue();
        }

        throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateFormatString());
    }
}
