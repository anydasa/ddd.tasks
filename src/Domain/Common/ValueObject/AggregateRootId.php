<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Exception\InvalidUUIDException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class AggregateRootId.
 */
abstract class AggregateRootId
{
    protected UuidInterface $uuid;

    /**
     * AggregateRootId constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        try {
            $this->uuid = Uuid::fromString($id);
        } catch (\InvalidArgumentException $e) {
            throw new InvalidUUIDException();
        }
    }

    public function equals(AggregateRootId $aggregateRootId): bool
    {
        return $this->uuid->equals($aggregateRootId->uuid);
    }

    public function __toString(): string
    {
        return $this->uuid->__toString();
    }
}
