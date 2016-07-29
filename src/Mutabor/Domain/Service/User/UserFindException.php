<?php


namespace Mutabor\Domain\Service\User;


use Mutabor\Domain\Validation\ValidationSummaryException;

class UserFindException extends ValidationSummaryException
{
    public function __construct($message = "User find fail", array $errorSummary = [])
    {
        parent::__construct($message, $errorSummary);
    }

}