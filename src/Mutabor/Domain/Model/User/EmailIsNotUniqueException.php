<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\Validation\ValueIsNotUniqueException;

class EmailIsNotUniqueException extends ValueIsNotUniqueException
{
    public function __construct($message = null)
    {
        parent::__construct($message ?? "Email is not unique", parent::EMAIL_IS_NOT_UNIQUE);
    }

}