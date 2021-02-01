<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\Doctrine\Type;

use App\Domain\Task\ValueObject\TaskId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ramsey\Uuid\Doctrine\UuidType;

class TaskIdType extends UuidType
{
    const TASK_ID = 'taskId';

    public function getName(): string
    {
        return self::TASK_ID;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): TaskId
    {
        return new TaskId(parent::convertToPHPValue($value, $platform)->__toString());
    }
}
