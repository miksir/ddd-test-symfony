<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\VO\ValueObject;

class Password implements ValueObject
{
    private $password;

    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return bool
     * @throws PasswordException
     */
    public function equals(Password $password) : bool
    {
        return $this->password === (string)$password;
    }
}