<?php


namespace Mutabor\Application\DTO;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

class UserIdentityRequest
{
    /**
     * Login, can use phone or email as login
     * @var string
     * @Type("string")
     * @Assert\NotBlank()
     */
    private $login;
    /**
     * Plain text password
     * @var string
     * @Type("string")
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}