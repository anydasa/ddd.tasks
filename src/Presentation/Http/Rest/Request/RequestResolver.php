<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Request;

use App\Application\Exception\CommandValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    private SerializerInterface $serializer;

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), RequestInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        $customRequest = $this->serializer->deserialize(
            $request->getContent(),
            $argument->getType(),
            'json',
        );

        $errors = $this->validator->validate($customRequest);

        if (count($errors) > 0) {
            throw new CommandValidationException($errors);
        }

        yield $customRequest;
    }
}
