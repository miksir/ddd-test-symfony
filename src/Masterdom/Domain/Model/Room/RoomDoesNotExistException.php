<?php


namespace Masterdom\Domain\Model\Room;


use Masterdom\Domain\Validation\ValidationException;

class RoomDoesNotExistException extends ValidationException
{
    public function __construct($message = 'Provided room does not exist')
    {
        parent::__construct($message, self::ROOM_DOEST_NOT_EXISTS);
    }

}