<?php


namespace Mutabor\Domain\Model\User;


interface EmailSpecification
{
    public function isSatisfiedBy(Email $email);
}