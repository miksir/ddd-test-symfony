<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\Validation\ValidationException;

class EmailFormatInvalidException extends ValidationException
{
    public function __construct($message = null)
    {
        parent::__construct($message ?? "Invalid email format", parent::EMAIL_FORMAT_INVALID);
    }
}