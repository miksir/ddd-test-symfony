<?php


namespace Masterdom\Domain\Model\User;


use Masterdom\Domain\Exception\DomainException;

class PasswordException extends DomainException
{
    public function __construct($message)
    {
        parent::__construct($message, 10003);
    }
}