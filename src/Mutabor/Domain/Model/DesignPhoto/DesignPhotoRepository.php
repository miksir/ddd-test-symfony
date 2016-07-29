<?php


namespace Mutabor\Domain\Model\DesignPhoto;


use Mutabor\Domain\Model\DesignProject\DesignInteriorId;

interface DesignPhotoRepository
{
    /**
     * @param DesignPhotoId $photoId
     * @return DesignPhoto
     * @throws DesignPhotoDoesNotExistException
     */
    public function byId(DesignPhotoId $photoId) : DesignPhoto;

    /**
     * @param DesignInteriorId $interiorId
     * @return DesignPhoto[]
     */
    public function byInterior(DesignInteriorId $interiorId) : array;

    public function add(DesignPhoto $photo);

    public function remove(DesignPhoto $photo);

    public function nextIdentity() : DesignPhotoId;
}