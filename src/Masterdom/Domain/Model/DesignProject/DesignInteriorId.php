<?php


namespace Masterdom\Domain\Model\DesignProject;


use Masterdom\Domain\VO\UuidValueObject;
use Masterdom\Domain\VO\ValueObject;

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