<?php


namespace Mutabor\Domain\Model\DesignProject;


use Mutabor\Domain\VO\UuidValueObject;
use Mutabor\Domain\VO\ValueObject;

class DesignProjectId extends UuidValueObject implements ValueObject
{
    /**
     * @param DesignProjectId $object
     * @return bool
     */
    public function equals(DesignProjectId $object) : bool
    {
        return (string)$this === (string)$object;
    }
}