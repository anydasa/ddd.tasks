<?php

declare(strict_types=1);

namespace App\Application\Query\Task\GetTask;

use Symfony\Component\Validator\Constraints as Assert;

class GetTaskByIdQuery
{
    /**
     * @Assert\Uuid
     * @Assert\NotBlank
     */
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
