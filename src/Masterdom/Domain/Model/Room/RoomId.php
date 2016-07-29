<?php


namespace Masterdom\Domain\Model\Room;


use Masterdom\Domain\VO\UuidValueObject;
use Masterdom\Domain\VO\ValueObject;

class RoomId extends UuidValueObject implements ValueObject
{
    /**
     * @param RoomId $object
     * @return bool
     */
    public function equals(RoomId $object) : bool
    {
        return (string)$this === (string)$object;
    }
}