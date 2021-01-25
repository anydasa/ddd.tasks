<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\Doctrine\Type;

use App\Domain\Task\ValueObject\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\IntegerType;

class TaskStatusType extends IntegerType
{
    const STATUS = 'taskStatus';

    public function getName(): string
    {
        return self::STATUS;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): Status
    {
        return Status::createFromValue($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        if ($value instanceof Status) {
            return $value->getValue();
        }

        throw ConversionException::conversionFailedFormat($value, $this->getName(), $platform->getDateFormatString());
    }
}
