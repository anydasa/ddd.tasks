<?php

declare(strict_types=1);

namespace App\Domain\Task\Repository;

use App\Domain\Task\View\TaskViewInterface;

interface TaskReadRepositoryInterface
{
    public function oneById(string $id): TaskViewInterface;

    public function allByCriteria(array $criteria, int $perPage, int $page);
}
