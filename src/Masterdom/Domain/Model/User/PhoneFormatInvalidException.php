<?php


namespace Masterdom\Domain\Model\User;


use Masterdom\Domain\Validation\ValidationException;

class PhoneFormatInvalidException extends ValidationException
{
    public function __construct($message = null)
    {
        parent::__construct($message ?? "Invalid phone format", parent::PHONE_FORMAT_INVALID);
    }
}