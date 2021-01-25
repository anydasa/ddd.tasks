<?php

declare(strict_types=1);

namespace App\Presentation\Http\Rest\Exception;

use App\Application\Exception\CommandValidationException;
use League\Tactician\Bundle\Middleware\InvalidCommandException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolation;

class HttpExceptionMap
{
    private array $exceptionMap;
    
    public function __construct(array $exceptionMap)
    {
        $this->exceptionMap = $exceptionMap;
    }

    public function resolveExceptionResponse(\Throwable $e): JsonResponse
    {
        if ($e instanceof HttpExceptionInterface) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatusCode());
        }

        if ($e instanceof CommandValidationException || $e instanceof InvalidCommandException) {
            $errors = array_map(function (ConstraintViolation $constraintViolation) {
                return $constraintViolation->getPropertyPath().' - '.$constraintViolation->getMessage();
            }, iterator_to_array($e->getViolations()));

            return new JsonResponse(['errors' => $errors], 400);
        }

        return new JsonResponse(['message' => $e->getMessage()], 500);
    }
}
