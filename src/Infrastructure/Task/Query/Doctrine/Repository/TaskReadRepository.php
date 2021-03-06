<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Query\Doctrine\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Task\Repository\TaskReadRepositoryInterface;
use App\Domain\Task\View\TaskCollectionViewInterface;
use App\Domain\Task\View\TaskViewInterface;
use App\Infrastructure\Task\Query\Doctrine\View\TaskListView;
use App\Infrastructure\Task\Query\Doctrine\View\TaskView;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class FormReadModelRepository.
 */
class TaskReadRepository implements TaskReadRepositoryInterface
{
    const TABLE_NAME = 'task';

    private array $columnMapping = [
        'label' => 'label_value',
    ];

    private Connection $connection;

    private DenormalizerInterface $normalizer;

    public function __construct(Connection $connection, DenormalizerInterface $normalizer)
    {
        $this->connection = $connection;
        $this->normalizer = $normalizer;
    }

    /**
     * @throws Exception
     */
    public function oneById(string $id): TaskViewInterface
    {
        $qb = $this->connection->createQueryBuilder();
        $result = $qb->select('*')
            ->from(self::TABLE_NAME)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute()
            ->fetch();

        if (false === $result) {
            throw new EntityNotFoundException('Task not found');
        }

        return new TaskView(
            $result['id'],
            $result['label_value'],
            $result['description_value']
        );
    }

    public function allByCriteria(array $criteria, int $perPage, int $page): TaskCollectionViewInterface
    {
        $qb = $this->connection->createQueryBuilder();

        $this->applyFilter($qb, $criteria);

        $statement = $qb->select('count(id)')->from(self::TABLE_NAME)
            ->execute();

        $count = $statement->fetchColumn(0);

        $statement = $qb->select('*')->from(self::TABLE_NAME)
            ->orderBy('created_at', 'DESC')
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage)
            ->execute();

        $result = $statement->fetchAll();

        /** @var array $objects */
        $objects = $this->normalizer->denormalize($result, TaskView::class.'[]');

        return new TaskListView(
            $objects,
            $page,
            $perPage,
            (int) $count
        );
    }

    /**
     * @throws \Exception
     */
    private function applyFilter(QueryBuilder $queryBuilder, array $filter): void
    {
        foreach ($filter as $column => $value) {
            $queryBuilder->andWhere($this->getMappedField($column).'= :'.$column)
                ->setParameter(':'.$column, $value);
        }
    }

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    private function getMappedField(string $column)
    {
        if (!isset($this->columnMapping[$column])) {
            throw new \Exception('Invalid filter data');
        }

        return $this->columnMapping[$column];
    }
}
