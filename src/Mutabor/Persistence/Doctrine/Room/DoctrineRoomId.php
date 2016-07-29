<?php


namespace Mutabor\Persistence\Doctrine\Room;


use Doctrine\DBAL\Types\GuidType;
use Mutabor\Domain\Model\Room\RoomId;
use Mutabor\Persistence\Doctrine\Attribute\DoctrineAttributeId;
use Mutabor\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

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