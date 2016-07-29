<?php


namespace Mutabor\Domain\Model\Role;


class Role
{
    /**
     * @var RoleId
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    private function __construct()
    {

    }

    public static function Designer()
    {
        $self = new self;
        $self->id = new RoleId('09b99bec-a1bc-461d-a481-f7b7d0b45c9d');
        $self->name = 'Designer';
        return $self;
    }

    public static function Customer()
    {
        $self = new self;
        $self->id = new RoleId('2ce48584-dfb0-40dd-a97a-ce7e55ca85dd');
        $self->name = 'Customer';
        return $self;
    }

    public static function Admin()
    {
        $self = new self;
        $self->id = new RoleId('8a810b6f-4e5e-48e6-a076-c84d70fe3e8c');
        $self->name = 'Administrator';
        return $self;
    }

    /**
     * @return RoleId
     */
    public function getId() : RoleId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}