<?php


namespace Mutabor\Domain\Model\Room;


use Mutabor\Domain\VO\UuidValueObject;
use Mutabor\Domain\VO\ValueObject;

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