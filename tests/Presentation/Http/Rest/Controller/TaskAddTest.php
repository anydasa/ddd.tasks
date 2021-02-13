<?php

namespace Test\Presentation\Http\Rest\Controller;

use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Test\Presentation\Http\Rest\RestTestCase;

class TaskAddTest extends RestTestCase
{
    /**
     * @test
     * @group e2e
     * @dataProvider validPayloadData
     */
    public function given_a_valid_request_should_return_a_201_status_code(array $params)
    {
        $this->post('/api/v1/task/', $params);

        $this->assertEquals(Response::HTTP_CREATED, $this->response()->getStatusCode());
    }

    /**
     * @test
     * @group e2e
     * @dataProvider wrongPayloadData
     */
    public function given_a_wrong_request_should_return_a_400_status_code($params)
    {
        $this->post('/api/v1/task/', $params);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->response()->getStatusCode());
    }

    /**
     * @test
     * @group e2e
     * @dataProvider wrongPayloadData
     */
    public function given_a_wrong_request_should_return_a_response_with_errors($params)
    {
        $this->post('/api/v1/task/', $params);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->response()->getStatusCode());
        $this->assertArrayHasKey('errors', $this->responseData());
    }

    /**
     * @test
     * @group e2e
     */
    public function given_a_same_request_twice_should_return_a_409_status_code()
    {
        $params = [
            'id' => Uuid::uuid4()->toString(),
            'label' => 'Label1',
            'description' => 'Description1',
            'priority' => PriorityTypes::CODE_LOW,
            'dueDate' => '2020-12-01',
        ];
        $this->post('/api/v1/task/', $params);
        $this->post('/api/v1/task/', $params);

        $this->assertEquals(Response::HTTP_CONFLICT, $this->response()->getStatusCode());
    }

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
            [[
                'id' => Uuid::uuid4()->toString(),
                'label' => 'Label1',
                'description' => 'Description1',
                'priority' => PriorityTypes::CODE_LOW,
            ]],
        ];
    }
}
