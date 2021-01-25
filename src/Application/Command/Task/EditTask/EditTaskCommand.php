<?php

declare(strict_types=1);

namespace App\Application\Command\Task\EditTask;

class EditTaskCommand
{
    private string $id;
    private string $label;
    private string $description;

    /**
     * @param string $id
     * @param string $label
     * @param string $description
     */
    public function __construct(string $id, string $label, string $description)
    {
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
