<?php


namespace Masterdom\Domain\Model\User;


use Masterdom\Domain\VO\UuidValueObject;
use Masterdom\Domain\VO\ValueObject;

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