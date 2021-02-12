<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Persistence\Doctrine\Repository;

use App\Domain\Common\Exception\ConflictEntityException;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Task\Model\Task;
use App\Domain\Task\Repository\TaskRepositoryInterface;
use App\Domain\Task\ValueObject\TaskId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class FormRepository.
 */
class TaskRepository extends ServiceEntityRepository implements TaskRepositoryInterface
{
    /**
     * FormRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @throws ORMException
     */
    public function store(Task $task): void
    {
        try {
            $this->_em->persist($task);
            $this->_em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new ConflictEntityException();
        }
    }

    public function getById(TaskId $id): Task
    {
        /** @var Task|null $task */
        $task = $this->find($id);

        if (null === $task) {
            throw new EntityNotFoundException('Task not found');
        }

        return $task;
    }

    /**
     * @throws ORMException
     */
    public function remove(Task $task): void
    {
        $this->_em->remove($task);
        $this->_em->flush();
    }
}
