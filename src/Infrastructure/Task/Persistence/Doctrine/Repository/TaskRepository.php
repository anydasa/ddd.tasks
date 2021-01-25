<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\Doctrine\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Task\Model\Task;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\ValueObject\TaskId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class FormRepository.
 */
class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    /**
     * FormRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param Task $task
     * @throws ORMException
     */
    public function add(Task $task): void
    {
        $this->_em->persist($task);
    }

    /**
     * @param TaskId $id
     * @return Task
     */
    public function getById(TaskId $id): Task
    {
        /** @var Task|null $form */
        $form = $this->findOneBy(['id' => $id, 'deleted' => false]);

        if (null === $form) {
            throw new EntityNotFoundException('Task not found');
        }

        return $form;
    }

    /**
     * @param Task $task
     * @throws ORMException
     */
    public function remove(Task $task): void
    {
        $this->_em->remove($task);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function flush(): void
    {
        $this->_em->flush();
    }
}
