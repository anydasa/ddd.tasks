<?php

declare(strict_types=1);

namespace App\Domain\Task\Model;

use App\Domain\Task\Event\TaskWasCreated;
use App\Domain\Task\ValueObject\Description;
use App\Domain\Task\ValueObject\DueDate;
use App\Domain\Task\ValueObject\Label;
use App\Domain\Task\ValueObject\Priority;
use App\Domain\Task\ValueObject\Status;
use App\Domain\Task\ValueObject\TaskId;
use BornFree\TacticianDomainEvent\Recorder\ContainsRecordedEvents;
use BornFree\TacticianDomainEvent\Recorder\EventRecorderCapabilities;

final class Task implements ContainsRecordedEvents
{
    use EventRecorderCapabilities;

    private TaskId $id;

    private Label $label;

    private Description $description;

    private Status $status;

    private Priority $priority;

    private DueDate $dueDate;

    private function __construct()
    {
    }

    public static function create(TaskId $id, Label $label, Description $description, Status $status, Priority $priority, DueDate $dueDate): self
    {
        $self = new self();
        $self->id = $id;
        $self->label = $label;
        $self->description = $description;
        $self->status = $status;
        $self->priority = $priority;
        $self->dueDate = $dueDate;

        $self->record(new TaskWasCreated(
            (string) $id,
            (string) $label,
            (string) $description
        ));

        return $self;
    }

    public function changeDetails(Label $label, Description $description): void
    {
        $this->label = $label;
        $this->description = $description;
    }

    public function changeDueDate(DueDate $dueDate): void
    {
        if ($this->dueDate->equal($dueDate)) {
            return;
        }

        $this->dueDate = $dueDate;
    }

    public function changePriority(Priority $priority): void
    {
        if ($this->priority->equal($priority)) {
            return;
        }

        $this->priority = $priority;
    }

    public function getLabel(): Label
    {
        return $this->label;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}
