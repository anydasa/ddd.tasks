<?php

declare(strict_types=1);

namespace App\Domain\Task\Repository;

use App\Domain\Task\View\TaskViewInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface FormReadModelRepositoryInterface.
 */
interface TaskReadModelRepositoryInterface
{
    public function oneById(UuidInterface $uuid): TaskViewInterface;

    /**
     * @return mixed
     */
    public function allByCriteria(array $criteria, int $perPage, int $page);

    public function oneWithRelatedById(UuidInterface $uuid): TaskViewInterface;
}
