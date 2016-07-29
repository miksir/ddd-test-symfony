<?php


namespace Masterdom\Domain\Model\User;


use Masterdom\Domain\Validation\ValueIsNotUniqueException;

class PhoneIsNotUniqueException extends ValueIsNotUniqueException
{
    public function __construct($message = null)
    {
        parent::__construct($message ?? "Phone is not unique", parent::PHONE_IS_NOT_UNIQUE);
    }

}