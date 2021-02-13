<?php

namespace Test\Domain\Task;

use App\Domain\Task\Task;
use App\Domain\Task\ValueObject\Description;
use App\Domain\Task\ValueObject\DueDate;
use App\Domain\Task\ValueObject\Label;
use App\Domain\Task\ValueObject\Priority;
use App\Domain\Task\ValueObject\Status;
use App\Domain\Task\ValueObject\TaskId;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * @test
     * @group unit
     */
    public function given_a_valid_data_it_should_create_a_task_instance()
    {
        $id = new TaskId('f6821ac7-c22d-4a62-b84e-69c014f79519');
        $label = new Label('label');
        $description = new Description('Description');
        $status = Status::createFromValue(Status\StatusTypes::BACKLOG);
        $priority = Priority::createFromCode(Priority\PriorityTypes::CODE_HIGH);
        $dueDate = new DueDate('2020-12-01');

        $task = Task::create($id, $label, $description, $status, $priority, $dueDate);

        $this->assertSame($id, $task->getId());
        $this->assertSame($label, $task->getLabel());
        $this->assertSame($description, $task->getDescription());
        $this->assertSame($status, $task->getStatus());
        $this->assertSame($priority, $task->getPriority());
        $this->assertSame($dueDate, $task->getDueDate());

        $this->assertInstanceOf(Task::class, $task);
    }
}
