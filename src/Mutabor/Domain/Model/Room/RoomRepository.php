<?php


namespace Mutabor\Domain\Model\Room;


use Mutabor\Domain\VO\SiteName;

interface RoomRepository
{
    /**
     * @param RoomId $id
     * @return Room
     * @throws RoomDoesNotExistException
     */
    public function byId(RoomId $id) : Room;

    /**
     * @param SiteName $siteName
     * @return Room
     * @throws RoomDoesNotExistException
     */
    public function bySiteName(SiteName $siteName) : Room;

    /**
     * @return Room[]
     */
    public function all() : array;
}