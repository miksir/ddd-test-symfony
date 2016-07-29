<?php


namespace Mutabor\Domain\Model\User;


interface PasswordHashing
{
    public function encodePassword(Password $raw) : HashedPassword;

    public function isPasswordValid(HashedPassword $encoded, Password $raw) : bool;
}