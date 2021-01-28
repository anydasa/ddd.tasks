<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Query\Doctrine\View;

use App\Domain\Task\View\TaskViewInterface;

class TaskView implements TaskViewInterface
{
    private string $id;

    private string $label;

    private string $description;

    public function __construct(
        string $id,
        string $label,
        string $description
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->description = $description;
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
}
