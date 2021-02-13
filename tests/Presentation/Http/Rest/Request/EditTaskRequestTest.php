<?php

namespace Test\Presentation\Http\Rest\Request;

use App\Presentation\Http\Rest\Request\EditTaskRequest;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EditTaskRequestTest extends KernelTestCase
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->serializer = $kernel->getContainer()->get('serializer');
        $this->validator = $kernel->getContainer()->get('validator');
    }

    /**
     * @test
     * @group unit
     * @dataProvider validPayload
     */
    public function given_a_valid_payload_should_return_0_errors($payload)
    {
        $customRequest = $this->serializer->deserialize(
            $payload,
            EditTaskRequest::class,
            'json',
        );

        $errors = $this->validator->validate($customRequest);

        $this->assertEquals(0, count($errors));
    }

    /**
     * @test
     * @group unit
     * @dataProvider invalidPayload
     */
    public function given_a_bad_payload_should_return_errors($payload, $fieldName, $errorCode)
    {
        $customRequest = $this->serializer->deserialize(
            $payload,
            EditTaskRequest::class,
            'json',
        );

        $errors = $this->validator->validate($customRequest);

        $this->assertEquals($fieldName, $errors->get(0)->getPropertyPath());
        $this->assertEquals($errorCode, $errors->get(0)->getCode());
    }

    public function validPayload(): array
    {
        return [
            ['{"label":"Label1","description":"Description","priority":"low","dueDate":"2020-12-01"}'],
        ];
    }

    public function invalidPayload(): array
    {
        return [
            [
                '{"label":"","description":"Description","priority":"low","dueDate":"2020-12-01"}',
                'label',
                NotBlank::IS_BLANK_ERROR,
            ],
            [
                '{"label":"Label","description":"","priority":"low","dueDate":"2020-12-01"}',
                'description',
                NotBlank::IS_BLANK_ERROR,
            ],
            [
                '{"label":"Label","description":"Description","priority":"wrong","dueDate":"2020-12-01"}',
                'priority',
                Choice::NO_SUCH_CHOICE_ERROR,
            ],
        ];
    }
}
