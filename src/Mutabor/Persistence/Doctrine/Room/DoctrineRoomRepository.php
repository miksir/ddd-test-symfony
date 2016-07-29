<?php


namespace Mutabor\Persistence\Doctrine\Room;


use Mutabor\Domain\Model\Room\Room;
use Mutabor\Domain\Model\Room\RoomDoesNotExistException;
use Mutabor\Domain\Model\Room\RoomId;
use Mutabor\Domain\Model\Room\RoomRepository;
use Mutabor\Domain\VO\SiteName;
use Mutabor\Persistence\Doctrine\DoctrineEntityRepository;

class DoctrineRoomRepository extends DoctrineEntityRepository implements RoomRepository 
{
    public function relatedEntity() : string
    {
        return Room::class;
    }

    /**
     * @param RoomId $id
     * @return Room
     * @throws RoomDoesNotExistException
     */
    public function byId(RoomId $id) : Room
    {
        $room = $this->find($id);
        if (is_null($room)) {
            throw new RoomDoesNotExistException();
        }
        return $room;
    }

    /**
     * @param SiteName $siteName
     * @return Room
     * @throws RoomDoesNotExistException
     */
    public function bySiteName(SiteName $siteName) : Room
    {
        $room = $this->findOneBy(['site_name' => (string)$siteName]);
        if (is_null($room)) {
            throw new RoomDoesNotExistException();
        }
        return $room;
    }

    /**
     * @return Room[]
     */
    public function all() : array
    {
        return $this->findAll();
    }
}