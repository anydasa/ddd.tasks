<?php

declare(strict_types=1);

namespace App\Domain\Common\Event;

/**
 * Class Event.
 */
abstract class Event
{
    /**
     * @var \DateTimeImmutable
     */
    protected $happenedAt;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->happenedAt = new \DateTimeImmutable();
    }

    public function getHappenedAt(): \DateTimeImmutable
    {
        return $this->happenedAt;
    }
}
