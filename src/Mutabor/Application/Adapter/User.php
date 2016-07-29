<?php


namespace Mutabor\Application\Adapter;

use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Mutabor\Domain\Model\User\User as DomainUser;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Groups;

/**
 * @ExclusionPolicy("ALL")
 */
class User implements UserInterface
{
    /**
     * ID, uuid4 format
     * @var string
     * @Expose
     * @SerializedName("id")
     * @Type("string")
     */
    private $username = '';
    /**
     * @var string
     */
    private $password = '';
    /**
     * @var string
     * @Expose
     * @Type("string")
     */
    private $firstname = '';
    /**
     * @var string
     * @Expose
     * @Type("string")
     */
    private $lastname = '';
    /**
     * Email. See http://php.net/manual/en/function.filter-var.php FILTER_VALIDATE_EMAIL
     * @var string
     * @Expose
     * @Type("string")
     * @Groups({"fullinfo"})
     */
    private $email = '';
    /**
     * Phone number started from +7 or 8 and comprising 10 digits more. Any other symbols are allowed and striped.
     * @var string
     * @Expose
     * @Type("string")
     * @Groups({"fullinfo"})
     */
    private $phone = '';
    /**
     * @var DomainUser
     */
    private $domain_user;
    
    /**
     * @param DomainUser $user
     * @return User
     */
    public static function createFromDomainUser(DomainUser $user)
    {
        $self = new self();
        $self->username = (string)$user->getId();
        $self->password = (string)$user->getPassword();
        $self->email = (string)$user->getEmail();
        $self->phone = (string)$user->getPhone();
        $self->firstname = $user->getFullName()->getFirstName();
        $self->lastname = $user->getFullName()->getLastName();
        $self->domain_user = $user;
        return $self;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }
    
    /**
     * @return \Mutabor\Domain\Model\User\User|null
     */
    public function getDomainUser()
    {
        return $this->domain_user;
    }
}