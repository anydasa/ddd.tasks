<?php

namespace App\Application\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class CommandValidationException extends \RuntimeException
{
    private ConstraintViolationListInterface $violations;

    public function __construct(ConstraintViolationListInterface $violations, $message = 'Validation Error', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->violations = $violations;
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
