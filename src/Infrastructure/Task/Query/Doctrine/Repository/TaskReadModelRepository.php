<?php

declare(strict_types=1);

namespace App\Infrastructure\Task\Query\Doctrine\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Task\Repository\TaskReadModelRepositoryInterface;
use App\Domain\Task\View\TaskCollectionViewInterface;
use App\Domain\Task\View\TaskViewInterface;
use App\Infrastructure\Task\Query\Doctrine\View\TaskListView;
use App\Infrastructure\Task\Query\Doctrine\View\TaskView;
use App\Infrastructure\Task\Query\Doctrine\View\FormWithRelationsView;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class FormReadModelRepository.
 */
class TaskReadModelRepository implements TaskReadModelRepositoryInterface
{
    const TABLE_NAME = 'form';

    /**
     * @var array
     */
    private $columnMapping = [
        'label' => 'label_value',
    ];

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var DenormalizerInterface
     */
    private $normalizer;

    /**
     * FormReadModelRepository constructor.
     */
    public function __construct(Connection $connection, DenormalizerInterface $normalizer)
    {
        $this->connection = $connection;
        $this->normalizer = $normalizer;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Query\QueryException
     */
    public function oneById(UuidInterface $uuid): TaskViewInterface
    {
        $qb = $this->connection->createQueryBuilder();
        $result = $qb->select('*')->from(self::TABLE_NAME)
            ->where('form.id = :id')
            ->andWhere('form.deleted = false')
            ->setParameter('id', $uuid->toString())
            ->execute()
            ->fetch();

        if (false === $result) {
            throw new EntityNotFoundException('Form not found');
        }

        return new TaskView(
            $result['id'],
            $result['label_value'],
            $result['description_value'],
            $result['created_at'],
            $result['updated_at']
        );
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function oneWithRelatedById(UuidInterface $uuid): TaskViewInterface
    {
        $query = 'SELECT 
        *, (
		SELECT json_agg(q) AS questions FROM
    		(SELECT *, 
    		  (
    		    SELECT json_agg(c) as choices from choice as c where q.id=c.question_id and c.deleted=false
    		  ) choices FROM question
    		    as q WHERE q.form_id=form.id and q.deleted = false
    		)
      q) FROM form where id = :id and deleted = false';

        $statement = $this->connection->executeQuery($query, ['id' => $uuid->toString()]);

        $result = $statement->fetch();

        if (false === $result) {
            throw new EntityNotFoundException('Form not found');
        }

        $result['questions'] = json_decode($result['questions'] ?? '{}', true);

        /** @var TaskViewInterface $object */
        $object = $this->normalizer->denormalize($result, FormWithRelationsView::class);

        return $object;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Query\QueryException
     * @throws \Exception
     */
    public function allByCriteria(array $criteria, int $perPage, int $page): TaskCollectionViewInterface
    {
        $qb = $this->connection->createQueryBuilder();

        $this->applyFilter($qb, $criteria);

        $statement = $qb->select('count(form.id)')->from(self::TABLE_NAME)
            ->andWhere('deleted = false')
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

        $formCollection = new TaskListView(
            $objects,
            $page,
            $perPage,
            (int) $count
        );

        return $formCollection;
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
