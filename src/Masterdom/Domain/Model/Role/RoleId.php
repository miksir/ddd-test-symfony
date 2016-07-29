<?php


namespace Masterdom\Domain\Model\Role;


use Masterdom\Domain\VO\UuidValueObject;
use Masterdom\Domain\VO\ValueObject;

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