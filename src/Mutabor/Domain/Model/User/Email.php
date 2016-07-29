<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\VO\ValueObject;

class Email implements ValueObject
{
    private $email;

    /**
     * Email constructor.
     * @param string $email
     * @throws EmailFormatInvalidException
     */
    public function __construct(string $email)
    {
        if($email && filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            throw new EmailFormatInvalidException("Invalid format of email \"{$email}\"");
        }
        $this->email = $email;
    }

    public function __toString() : string
    {
        return $this->email;
    }

    public function equals(Email $object) : bool
    {
        return strtolower((string)$this) === strtolower((string)$object);
    }
}