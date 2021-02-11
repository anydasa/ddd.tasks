<?php

namespace Test\Presentation\Http\Rest\Controller\TaskAdd;

use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use Ramsey\Uuid\Uuid;

class DataProvider
{
    public function validPayloadData(): array
    {
        return [
            [[
                'id' => Uuid::uuid4()->toString(),
                'label' => 'Label1',
                'description' => 'Description1',
                'priority' => PriorityTypes::CODE_LOW,
                'dueDate' => '2020-12-01',
            ]],
        ];
    }

    public function wrongPayloadData(): array
    {
        return [
            [[
                'id' => Uuid::uuid4()->toString(),
                'label' => 'Label1',
                'description' => 'Description1',
                'priority' => PriorityTypes::CODE_LOW,
                'dueDate' => '2020-12-0',
            ]],
            [[
                'id' => Uuid::uuid4()->toString(),
                'label' => 'Label1',
                'description' => 'Description1',
                'priority' => 'Wrong priority',
                'dueDate' => '2020-12-01',
            ]],
            [[
                'id' => Uuid::uuid4()->toString(),
                'label' => 'Label1',
                'description' => '',
                'priority' => PriorityTypes::CODE_LOW,
                'dueDate' => '2020-12-01',
            ]],
            [[
                'id' => Uuid::uuid4()->toString(),
                'label' => '',
                'description' => 'Description1',
                'priority' => PriorityTypes::CODE_LOW,
                'dueDate' => '2020-12-01',
            ]],
            [[
                'id' => 'sasd',
                'label' => 'Label1',
                'description' => 'Description1',
                'priority' => PriorityTypes::CODE_LOW,
                'dueDate' => '2020-12-01',
            ]],
        ];
    }
}
