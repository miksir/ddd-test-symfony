<?php


namespace Masterdom\Persistence\Doctrine\Room;


use Doctrine\DBAL\Types\GuidType;
use Masterdom\Domain\Model\Room\RoomId;
use Masterdom\Persistence\Doctrine\Attribute\DoctrineAttributeId;
use Masterdom\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

class DoctrineRoomId extends DoctrineAttributeId
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return RoomId::class;
    }

    /**
     * Property inside VO to set value
     * @return string
     */
    protected function getVOPropertyName()
    {
        return 'uuid';
    }
}