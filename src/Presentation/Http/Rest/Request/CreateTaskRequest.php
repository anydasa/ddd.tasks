<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Request;

use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *      title="Create Task request",
 *      description="Create Task request body data",
 *      type="object",
 * )
 */
class CreateTaskRequest implements RequestInterface
{
    /**
     * @Assert\Uuid
     * @OA\Property(property="id", type="string", format="uuid")
     */
    private ?string $id = null;

    /**
     * @Assert\NotBlank
     * @OA\Property(property="label", type="string", example="Some Label")
     */
    private string $label;

    /**
     * @Assert\NotBlank
     * @OA\Property(property="description", type="string", example="Some Description")
     */
    private string $description;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices=PriorityTypes::VALUE_CODE_MAP)
     * @OA\Property(property="priority", description="10 - low; 20 - medium; 30 - high")
     */
    private string $priority;

    /**
     * @Assert\NotBlank
     * @Assert\Date
     * @OA\Property(property="dueDate", example="2020-12-31", description="A Y-m-d formatted value")
     */
    private string $dueDate;

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

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }
}
