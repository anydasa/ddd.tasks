<?php

namespace Test\Presentation\Http\Rest\Controller;

use App\Domain\Task\ValueObject\Priority\PriorityTypes;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Test\Presentation\Http\Rest\RestTestCase;

class TaskGetTest extends RestTestCase
{
    /**
     * @test
     * @group e2e
     */
    public function given_a_valid_request_should_return_a_200_status_code()
    {
        $params = [
            'id' => Uuid::uuid4()->toString(),
            'label' => 'Label1',
            'description' => 'Description1',
            'priority' => PriorityTypes::CODE_LOW,
            'dueDate' => '2020-12-01',
        ];

        $this->post('/api/v1/task/', $params);

        $this->get('/api/v1/task/'.$params['id']);

        $this->assertEquals(Response::HTTP_OK, $this->response()->getStatusCode());
    }

    /**
     * @test
     * @group e2e
     * @dataProvider requestResponseData
     */
    public function given_a_valid_request_should_return_a_valid_response($taskData, $response)
    {
        $this->post('/api/v1/task/', $taskData);

        $this->get('/api/v1/task/'.$taskData['id']);

        $this->assertSame($response, $this->responseData());
    }

    /**
     * @test
     * @group e2e
     */
    public function given_a_valid_request_should_return_404_status_code_when_not_exist()
    {
        $this->get('/api/v1/task/'.Uuid::uuid4()->toString());

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->response()->getStatusCode());
    }

    public function requestResponseData(): array
    {
        return [
            [
                [
                    'id' => $id = Uuid::uuid4()->toString(),
                    'label' => 'Label1',
                    'description' => 'Description1',
                    'priority' => PriorityTypes::CODE_LOW,
                    'dueDate' => '2020-12-01',
                ],
                [
                    'id' => $id,
                    'label' => 'Label1',
                    'description' => 'Description1',
                ],
            ],
        ];
    }
}
