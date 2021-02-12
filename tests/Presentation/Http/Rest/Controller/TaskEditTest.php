<?php

namespace Test\Presentation\Http\Rest\Controller;

use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Test\Presentation\Http\Rest\RestTestCase;

class TaskEditTest extends RestTestCase
{
    /**
     * @test
     * @dataProvider validPayloadData
     */
    public function given_a_valid_request_should_return_a_201_status_code($params)
    {
        $id = $this->createTask();

        $this->put('/api/v1/task/'.$id, $params);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $this->response()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider wrongPayloadData
     */
    public function given_a_wrong_request_should_return_a_400_status_code($params)
    {
        $id = $this->createTask();

        $this->put('/api/v1/task/'.$id, $params);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->response()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider wrongPayloadData
     */
    public function given_a_wrong_request_should_return_a_response_with_errors($params)
    {
        $id = $this->createTask();

        $this->put('/api/v1/task/'.$id, $params);

        $this->assertArrayHasKey('errors', $this->responseData());
    }

    public function validPayloadData(): array
    {
        return [
            [[
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
                'label' => 'Label1',
                'description' => 'Description1',
                'priority' => PriorityTypes::CODE_LOW,
                'dueDate' => '2020-12-0',
            ]],
            [[
                'label' => 'Label1',
                'description' => 'Description1',
                'priority' => 'Wrong priority',
                'dueDate' => '2020-12-01',
            ]],
            [[
                'label' => 'Label1',
                'description' => '',
                'priority' => PriorityTypes::CODE_LOW,
                'dueDate' => '2020-12-01',
            ]],
            [[
                'label' => '',
                'description' => 'Description1',
                'priority' => PriorityTypes::CODE_LOW,
                'dueDate' => '2020-12-01',
            ]],
            [[
                'label' => 'Label1',
                'description' => 'Description1',
                'priority' => PriorityTypes::CODE_LOW,
            ]],
        ];
    }

    protected function createTask(): string
    {
        $id = Uuid::uuid4()->toString();
        $params = [
            'id' => $id,
            'label' => 'Label1',
            'description' => 'Description1',
            'priority' => PriorityTypes::CODE_LOW,
            'dueDate' => '2020-12-01',
        ];

        $this->post('/api/v1/task/', $params);

        return $id;
    }
}
