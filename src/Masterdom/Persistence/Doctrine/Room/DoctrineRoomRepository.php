<?php


namespace Masterdom\Persistence\Doctrine\Room;


use Masterdom\Domain\Model\Room\Room;
use Masterdom\Domain\Model\Room\RoomDoesNotExistException;
use Masterdom\Domain\Model\Room\RoomId;
use Masterdom\Domain\Model\Room\RoomRepository;
use Masterdom\Domain\VO\SiteName;
use Masterdom\Persistence\Doctrine\DoctrineEntityRepository;

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