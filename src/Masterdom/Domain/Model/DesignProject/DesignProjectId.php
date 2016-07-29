<?php


namespace Masterdom\Domain\Model\DesignProject;


use Masterdom\Domain\VO\UuidValueObject;
use Masterdom\Domain\VO\ValueObject;

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