<?php


namespace Masterdom\Domain\Exception;


use Masterdom\Domain\Validation\ValidationException;

class IdFormatInvalidException extends ValidationException
{
    public function __construct($message = 'Invalid ID format, UUID4 required')
    {
        parent::__construct($message, self::ID_FORMAT_INVALID);
    }

}