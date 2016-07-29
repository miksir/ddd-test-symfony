<?php


namespace Mutabor\Domain\Model\DesignStyle;


use Mutabor\Domain\VO\UuidValueObject;
use Mutabor\Domain\VO\ValueObject;

class DesignStyleId extends UuidValueObject implements ValueObject
{
    /**
     * @param DesignStyleId $object
     * @return bool
     */
    public function equals(DesignStyleId $object) : bool
    {
        return (string)$this === (string)$object;
    }
}