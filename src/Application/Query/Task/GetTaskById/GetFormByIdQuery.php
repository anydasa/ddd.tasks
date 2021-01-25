<?php

declare(strict_types=1);

namespace App\Application\Query\Task\GetTaskById;

use Ramsey\Uuid\UuidInterface;

/**
 * Class GetFormByIdQuery.
 */
class GetFormByIdQuery
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * GetFormByIdQuery constructor.
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @return UuidInterface
     */
    public function getId()
    {
        return $this->id;
    }
}
