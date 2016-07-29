<?php


namespace Masterdom\Domain\Model\Room;


use Masterdom\Domain\Model\Attribute\Attribute;

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