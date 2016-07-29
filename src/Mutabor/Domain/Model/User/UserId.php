<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\VO\UuidValueObject;
use Mutabor\Domain\VO\ValueObject;

class UserId extends UuidValueObject implements ValueObject
{
    /**
     * @param UserId $object
     * @return bool
     */
    public function equals(UserId $object) : bool
    {
        return (string)$this === (string)$object;
    }
}