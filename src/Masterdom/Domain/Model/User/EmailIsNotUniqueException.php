<?php


namespace Masterdom\Domain\Model\User;


use Masterdom\Domain\Validation\ValueIsNotUniqueException;

class EmailIsNotUniqueException extends ValueIsNotUniqueException
{
    public function __construct($message = null)
    {
        parent::__construct($message ?? "Email is not unique", parent::EMAIL_IS_NOT_UNIQUE);
    }

}