<?php


namespace Mutabor\Application\DTO;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class UserCreateRequest implements \Mutabor\Domain\Service\User\UserRequest
{
    /**
     * First name
     * @var string
     * @Type("string")
     * @Assert\NotBlank()
     */
    private $firstname;
    /**
     * Last name
     * @var string
     * @Type("string")
     * @Assert\NotBlank()
     */
    private $lastname;
    /**
     * Email. See http://php.net/manual/en/function.filter-var.php FILTER_VALIDATE_EMAIL
     * @var string
     * @Type("string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;
    /**
     * Phone number started from +7 or 8 and comprising 10 digits more. Any other symbols are allowed and striped.
     * @var string
     * @Type("string")
     * @Assert\NotBlank()
     */
    private $phone;
    /**
     * Plain text password
     * @var string
     * @Type("string")
     * @Assert\NotBlank()
     */
    private $password;
//    /**
//     * @var string
//     * @Type("string")
//     */
//    private $avatar;

    /**
     * @return string
     */
    public function getFirstname() : string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname() : string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone() : string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }
}