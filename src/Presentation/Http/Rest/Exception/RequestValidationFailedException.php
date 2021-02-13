<?php

namespace App\Presentation\Http\Rest\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RequestValidationFailedException extends RuntimeException
{
    private ConstraintViolationListInterface $violations;

    public function __construct(ConstraintViolationListInterface $violations)
    {
        $this->violations = $violations;
        parent::__construct($violations);
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
