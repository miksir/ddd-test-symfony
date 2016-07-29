<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\Validation\ValidationException;

class UserDoesNotExistException extends ValidationException
{
    public function __construct($message = "User not found")
    {
        parent::__construct($message, parent::USER_NOT_FOUND);
    }
}