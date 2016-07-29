<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\Validation\ValidationException;

class PhoneFormatInvalidException extends ValidationException
{
    public function __construct($message = null)
    {
        parent::__construct($message ?? "Invalid phone format", parent::PHONE_FORMAT_INVALID);
    }
}