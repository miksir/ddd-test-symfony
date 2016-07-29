<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\Exception\DomainException;

class PasswordException extends DomainException
{
    public function __construct($message)
    {
        parent::__construct($message, 10003);
    }
}