<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Query\Doctrine\View;

use App\Domain\Task\View\TaskViewInterface;

class TaskView implements TaskViewInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * FormView constructor.
     */
    public function __construct(
        string $id,
        string $labelValue,
        string $descriptionValue,
        string $createdAt,
        string $updatedAt
    ) {
        $this->id = $id;
        $this->label = $labelValue;
        $this->description = $descriptionValue;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
