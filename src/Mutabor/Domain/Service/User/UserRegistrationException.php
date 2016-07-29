<?php


namespace Mutabor\Domain\Service\User;


use Mutabor\Domain\Validation\ValidationSummaryException;

class UserRegistrationException extends ValidationSummaryException
{
    public function __construct($message = "User registration validation fail", array $errorSummary = [])
    {
        parent::__construct($message, $errorSummary);
    }
}