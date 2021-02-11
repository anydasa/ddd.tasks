<?php

namespace Test\Presentation\Http\Rest\Controller\TaskAdd;

use Symfony\Component\HttpFoundation\Response;
use Test\Presentation\Http\Rest\RestTestCase;

class TaskAddTest extends RestTestCase
{
    /**
     * @test
     * @dataProvider \Test\Presentation\Http\Rest\Controller\TaskAdd\DataProvider::validPayloadData
     */
    public function given_a_valid_request_should_return_a_200_status_code(array $params)
    {
        $this->post('/api/v1/task/', $params);

        $this->assertEquals(Response::HTTP_OK, $this->response()->getStatusCode());
    }

    /**
     * @test
     * @dataProvider \Test\Presentation\Http\Rest\Controller\TaskAdd\DataProvider::wrongPayloadData
     */
    public function given_a_wrong_request_should_return_a_400_status_code($params)
    {
        $this->post('/api/v1/task/', $params);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->response()->getStatusCode());
        $this->assertArrayHasKey('errors', $this->responseData());
    }
}
