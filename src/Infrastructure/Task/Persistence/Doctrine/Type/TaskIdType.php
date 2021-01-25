<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\Doctrine\Type;

use Ramsey\Uuid\Doctrine\UuidType;

class TaskIdType extends UuidType
{
    const TASK_ID = 'taskId';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::TASK_ID;
    }
}
