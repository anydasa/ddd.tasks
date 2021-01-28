<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Query\Doctrine\View;

use App\Domain\Task\View\TaskCollectionViewInterface;
use App\Infrastructure\Common\ListView;

class TaskListView extends ListView implements TaskCollectionViewInterface
{
}
