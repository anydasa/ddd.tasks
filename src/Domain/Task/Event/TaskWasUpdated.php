<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Common\Event\Event;

class TaskWasUpdated extends Event
{
    /**
     * @var string
     */
    private $taskId;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

    /**
     * FormWasUpdated constructor.
     */
    public function __construct(string $taskId, string $label, string $description)
    {
        parent::__construct();

        $this->taskId = $taskId;
        $this->label = $label;
        $this->description = $description;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
