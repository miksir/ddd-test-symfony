<?php


namespace Mutabor\Domain\Model\DesignStyle;


use Mutabor\Domain\Validation\ValidationException;

class DesignStyleDoesNotExistException extends ValidationException
{
    public function __construct($message = 'Provided design style does not exist')
    {
        parent::__construct($message, self::DESIGNSTYLE_DOEST_NOT_EXISTS);
    }
}