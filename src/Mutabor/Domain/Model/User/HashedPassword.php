<?php


namespace Mutabor\Domain\Model\User;


class HashedPassword
{
    private $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function __toString()
    {
        return $this->password;
    }

    /**
     * @param Password $password
     * @param PasswordHashing $passwordHashing
     * @return bool
     */
    public function equals(Password $password, PasswordHashing $passwordHashing)
    {
        return $passwordHashing->isPasswordValid($this, $password);
    }

}