<?php

declare(strict_types=1);

namespace App\Domain\Task\ValueObject;

use DateTime;

class DueDate
{
    private DateTime $value;

    public function __construct(string $value)
    {
        $this->value = new DateTime($value);
    }

    public function equal(self $other): bool
    {
        return 0 !== $this->value->diff($other->value)->days;
    }

    public function getValue(): DateTime
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format('Y-m-d');
    }
}
