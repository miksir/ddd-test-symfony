<?php


namespace Masterdom\Domain\Model\User;


use Masterdom\Domain\Validation\ValidationException;

class UserDoesNotExistException extends ValidationException
{
    public function __construct($message = "User not found")
    {
        parent::__construct($message, parent::USER_NOT_FOUND);
    }
}