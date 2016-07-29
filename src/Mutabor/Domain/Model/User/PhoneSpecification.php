<?php


namespace Mutabor\Domain\Model\User;


interface PhoneSpecification
{
    public function isSatisfiedBy(Phone $email);
}