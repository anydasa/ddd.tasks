<?php

declare(strict_types=1);

namespace App\Application\Command\Task\CreateTask;

use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateTaskCommand
{
    /**
     * @Assert\Uuid
     * @Assert\NotBlank
     */
    private string $id;

    /**
     * @Assert\NotBlank
     */
    private string $label;

    /**
     * @Assert\NotBlank
     */
    private string $description;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices=PriorityTypes::VALUE_CODE_MAP)
     */
    private string $priority;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     */
    private string $dueDate;

    public function __construct(string $id, string $label, string $description, string $priority, string $dueDate)
    {
        $this->id = $id;
        $this->label = $label;
        $this->description = $description;
        $this->priority = $priority;
        $this->dueDate = $dueDate;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }
}
