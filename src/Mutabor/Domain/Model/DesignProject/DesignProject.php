<?php


namespace Mutabor\Domain\Model\DesignProject;


use Mutabor\Domain\Adapter\ArrayCollection;
use Mutabor\Domain\Model\DesignStyle\DesignStyle;
use Mutabor\Domain\Model\Room\Room;
use Mutabor\Domain\Model\User\User;
use Mutabor\Domain\VO\SiteName;

class DesignProject
{
    /**
     * @var DesignProjectId
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var SiteName
     */
    private $siteName;
    /**
     * @var DesignInteriorCollection|DesignInterior[]
     */
    private $interior;
    /**
     * @var User
     */
    private $owner;


    private function __construct()
    {
        $this->interior = new DesignInteriorCollection();
    }

    /**
     * @param DesignProjectId $id
     * @param User $owner
     * @param string $name
     * @param string $description
     * @param SiteName $siteName
     * @return DesignProject
     */
    public static function create(
        DesignProjectId $id,
        User $owner,
        string $name,
        string $description,
        SiteName $siteName
    )
    {
        $self = new static;
        $self->id = $id;
        $self->name = $name;
        $self->description = $description;
        $self->siteName = $siteName;
        $self->owner = $owner;

        return $self;
    }

    public function update(
        string $name,
        string $description,
        SiteName $siteName
    )
    {
        $this->name = $name;
        $this->siteName = $siteName;
        $this->description = $description;
    }

    /**
     * @return DesignProjectId
     */
    public function getId() : DesignProjectId
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

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @return SiteName
     */
    public function getSiteName() : SiteName
    {
        return $this->siteName;
    }

    /**
     * @return DesignInteriorCollection|DesignInterior[]
     */
    public function getInteriors()
    {
        return $this->interior;
    }

    /**
     * @return User
     */
    public function getOwner() : User
    {
        return $this->owner;
    }
}