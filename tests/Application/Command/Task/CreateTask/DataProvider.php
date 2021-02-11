<?php

namespace Test\Application\Command\Task\CreateTask;

use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use Ramsey\Uuid\Uuid;

class DataProvider
{
    public function getValidCommandData(): array
    {
        return [
            [Uuid::uuid4()->toString(), 'Label1', 'Description1', PriorityTypes::CODE_LOW, '2020-12-01'],
            [Uuid::uuid4()->toString(), 'Label2', 'Description2', PriorityTypes::CODE_MEDIUM, '2021-12-01'],
            [Uuid::uuid4()->toString(), 'Label3', 'Description3', PriorityTypes::CODE_HIGH, '2021-12-01'],
        ];
    }

    public function getInvalidCommandData(): array
    {
        return [
            [Uuid::uuid4()->toString(), 'Label', 'Description', PriorityTypes::CODE_LOW, '2020-12-0'],
            [Uuid::uuid4()->toString(), 'Label', 'Description', 'Wrong priority', '2021-12-01'],
            [Uuid::uuid4()->toString(), 'Label', '', PriorityTypes::CODE_HIGH, '2021-12-01'],
            [Uuid::uuid4()->toString(), '', 'Description', PriorityTypes::CODE_HIGH, '2021-12-01'],
            ['', 'Label', 'Description', PriorityTypes::CODE_HIGH, '2021-12-01'],
        ];
    }
}
