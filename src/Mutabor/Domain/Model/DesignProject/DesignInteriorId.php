<?php


namespace Mutabor\Domain\Model\DesignProject;


use Mutabor\Domain\VO\UuidValueObject;
use Mutabor\Domain\VO\ValueObject;

class DesignInteriorId extends UuidValueObject implements ValueObject
{
    /**
     * @param DesignInteriorId $object
     * @return bool
     */
    public function equals(DesignInteriorId $object) : bool
    {
        return (string)$this === (string)$object;
    }
}