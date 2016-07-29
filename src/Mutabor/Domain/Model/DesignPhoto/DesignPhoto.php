<?php


namespace Mutabor\Domain\Model\DesignPhoto;

use Mutabor\Domain\Model\DesignProject\DesignInterior;
use Mutabor\Domain\Model\User\User;
use Mutabor\Domain\VO\File\Image;


class DesignPhoto
{
    /**
     * @var DesignPhotoId
     */
    private $id;
    /**
     * @var DesignInterior|null
     */
    private $interior = null;
    /**
     * @var Image
     */
    private $file;
    /**
     * @var User
     */
    private $owner;

    private function __construct()
    {

    }

    /**
     * @param DesignPhotoId $id
     * @param Image $file
     * @param User $user
     * @return DesignPhoto
     * @throws \Mutabor\Domain\VO\File\FileNotExistsException
     */
    public static function create(
        DesignPhotoId $id,
        Image $file,
        User $user
    )
    {
        $obj = new self;
        $obj->id = $id;
        $obj->file = $file;
        $obj->owner = $user;
        return $obj;
    }

    /**
     * @return DesignPhotoId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->file->getPath() ?? '';
    }

    /**
     * @param DesignInterior $interior
     */
    public function setDesignInterior(DesignInterior $interior)
    {
        $this->interior = $interior;
    }

    /**
     * @return Image
     */
    public function getFile() : Image
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getHash() : string
    {
        return $this->file->getHash();
    }

    /**
     * @return string
     */
    public function getFilename() : string
    {
        return $this->file->getName();
    }

    /**
     * @return int
     */
    public function getWidth() : int
    {
        return (int)$this->file->getWidth();
    }

    /**
     * @return int
     */
    public function getHeight() : int
    {
        return (int)$this->file->getHeight();
    }
    
    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }


}