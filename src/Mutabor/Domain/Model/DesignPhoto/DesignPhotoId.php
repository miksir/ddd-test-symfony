<?php


namespace Mutabor\Domain\Model\DesignPhoto;


use Mutabor\Domain\VO\UuidValueObject;
use Mutabor\Domain\VO\ValueObject;

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