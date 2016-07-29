<?php

namespace Mutabor\Domain\Model\User;

use Mutabor\Domain\Adapter\ArrayCollection;
use Mutabor\Domain\Model\Role\Role;

class User
{
    /**
     * UUID4
     * @var UserId
     */
    private $id;
    /**
     * @var FullName
     */
    private $fullname;
    /**
     * @var Email
     */
    private $email;
    /**
     * Phone in absolute format without plus (example: 79991112233)
     * @var Phone
     */
    private $phone;
    /**
     * @var HashedPassword
     */
    private $password;
    /**
     * @var Role[]|ArrayCollection
     */
    private $role;

    private function __construct()
    {
        $this->role = new ArrayCollection();
    }

    public static function register(
        UserId $id,
        FullName $fullName,
        Email $email,
        Phone $phone,
        HashedPassword $password
    ) : User
    {
        $obj = new self;
        $obj->id = $id;
        $obj->fullname = $fullName;
        $obj->email = $email;
        $obj->phone = $phone;
        $obj->password = $password;
        return $obj;
    }

    public function update(FullName $fullName, Email $email, Phone $phone, HashedPassword $password)
    {
        $this->fullname = $fullName;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
    }

    public function getId() : UserId
    {
        return $this->id;
    }

    public function getFirstname() : string
    {
        return $this->fullname->getFirstName();
    }

    public function getLastname() : string
    {
        return $this->fullname->getLastName();
    }

    public function getFullName() : FullName
    {
        return $this->fullname;
    }

    public function getEmail() : Email
    {
        return $this->email;
    }

    public function getPhone() : Phone
    {
        return $this->phone;
    }

    public function getPassword() : HashedPassword
    {
        return $this->password;
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role)
    {
        $this->role->add($role);
    }

    /**
     * @param Role $role
     * @return bool
     */
    public function revokeRole(Role $role)
    {
        return $this->role->removeElement($role);
    }
}

