<?php


namespace Masterdom\Domain\Model\DesignStyle;


use Masterdom\Domain\VO\UuidValueObject;
use Masterdom\Domain\VO\ValueObject;

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