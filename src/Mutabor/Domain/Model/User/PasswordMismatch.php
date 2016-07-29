<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\Validation\ValidationException;

class PasswordMismatch extends ValidationException
{
    public function __construct($message = null)
    {
        parent::__construct($message ?? "Password mismatch", self::PASSWORD_MISMATCH);
    }

}