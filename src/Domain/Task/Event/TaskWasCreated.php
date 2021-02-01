<?php

declare(strict_types=1);

namespace App\Domain\Task\Event;

use App\Domain\Common\Event\Event;

class TaskWasCreated extends Event
{
    /**
     * @var string
     */
    private $formId;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

    /**
     * FormWasCreated constructor.
     */
    public function __construct(string $taskId, string $label, string $description)
    {
        parent::__construct();

        $this->formId = $taskId;
        $this->label = $label;
        $this->description = $description;
    }
}
