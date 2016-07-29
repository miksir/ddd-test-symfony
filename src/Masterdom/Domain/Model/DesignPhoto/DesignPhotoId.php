<?php


namespace Masterdom\Domain\Model\DesignPhoto;


use Masterdom\Domain\VO\UuidValueObject;
use Masterdom\Domain\VO\ValueObject;

class DesignPhotoId extends UuidValueObject implements ValueObject
{
    /**
     * @param DesignPhotoId $object
     * @return bool
     */
    public function equals(DesignPhotoId $object) : bool
    {
        return (string)$this === (string)$object;
    }
}