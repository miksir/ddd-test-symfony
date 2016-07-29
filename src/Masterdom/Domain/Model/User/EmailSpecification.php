<?php


namespace Masterdom\Domain\Model\User;


interface EmailSpecification
{
    public function isSatisfiedBy(Email $email);
}