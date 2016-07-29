<?php


namespace Masterdom\Domain\Model\User;


interface PhoneSpecification
{
    public function isSatisfiedBy(Phone $email);
}