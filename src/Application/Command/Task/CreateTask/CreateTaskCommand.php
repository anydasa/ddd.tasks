<?php

declare(strict_types=1);

namespace App\Application\Command\Task\CreateTask;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateTaskCommand
{
    /**
     * @Assert\Uuid
     */
    private ?string $id;

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
     * @Assert\Choice({10,20,30})
     */
    private int $priority;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     */
    private string $dueDate;

    public function __construct(?string $id, string $label, string $description, int $priority, string $dueDate)
    {
        $this->id = $id;
        $this->label = $label;
        $this->description = $description;
        $this->priority = $priority;
        $this->dueDate = $dueDate;
    }

    public function getId(): ?string
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

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }
}
