<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\VO\ValueObject;

class FullName implements ValueObject
{
    private $firstname;
    private $lastname;

    public function __construct(string $firstname, string $lastname)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function __toString() : string
    {
        return $this->firstname . ' ' . $this->lastname; 
    }

    public function equals(FullName $object) : bool
    {
        return $this->getFirstName() === $object->getFirstName() && $this->getLastName() === $object->getLastName();
    }

    public function getFirstName() : string
    {
        return $this->firstname;
    }

    public function getLastName() : string
    {
        return $this->lastname;
    }
}