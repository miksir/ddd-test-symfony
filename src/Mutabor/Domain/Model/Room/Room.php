<?php


namespace Mutabor\Domain\Model\Room;


use Mutabor\Domain\Model\Attribute\Attribute;

class Room extends Attribute
{
    /**
     * @return RoomId
     */
    public function getId() : RoomId
    {
        return $this->id;
    }

}