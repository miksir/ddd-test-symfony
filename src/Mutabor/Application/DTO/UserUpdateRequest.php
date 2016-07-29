<?php


namespace Mutabor\Application\DTO;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateRequest implements \Mutabor\Domain\Service\User\UserUpdateRequest
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
     */
    private $password;
//    /**
//     * @var string
//     * @Type("string")
//     */
//    private $avatar;
    /**
     * Old password. Required if and only if <password> filed is not blank
     * @var string
     * @Type("string")
     */
    private $old_password;

    /**
     * @Assert\IsFalse(message="Old password required if and only if <password> field is not blank")
     */
    public function isOldPasswordRequired()
    {
        return $this->password && !$this->old_password;
    }

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
        return $this->password ?? '';
    }

    /**
     * @return string
     */
    public function getOldPassword() : string
    {
        return $this->old_password ?? '';
    }
}