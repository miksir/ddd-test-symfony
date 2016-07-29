<?php


namespace Mutabor\Domain\Model\Role;


use Mutabor\Domain\VO\UuidValueObject;
use Mutabor\Domain\VO\ValueObject;

class RoleId extends UuidValueObject implements ValueObject
{
    /**
     * @param RoleId $object
     * @return bool
     */
    public function equals(RoleId $object) : bool
    {
        return (string)$this === (string)$object;
    }
}