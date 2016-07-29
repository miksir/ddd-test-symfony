<?php


namespace Masterdom\Domain\Model\User;


use Masterdom\Domain\Validation\ValidationException;

class EmailFormatInvalidException extends ValidationException
{
    public function __construct($message = null)
    {
        parent::__construct($message ?? "Invalid email format", parent::EMAIL_FORMAT_INVALID);
    }
}