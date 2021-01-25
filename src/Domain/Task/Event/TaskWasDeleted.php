<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Common\Event\Event;

/**
 * Class FormWasDeleted.
 */
class TaskWasDeleted extends Event
{
    /**
     * @var string
     */
    private $taskId;

    /**
     * FormWasDeleted constructor.
     */
    public function __construct(string $taskId)
    {
        parent::__construct();

        $this->taskId = $taskId;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }
}
