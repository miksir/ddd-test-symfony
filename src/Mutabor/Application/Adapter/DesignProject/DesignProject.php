<?php


namespace Mutabor\Application\Adapter\DesignProject;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Mutabor\Application\Adapter\DesignProject\DesignInterior;
use Mutabor\Application\Adapter\User;
use Mutabor\Domain\Model\DesignProject\DesignProject as DomainDesignProject;

/**
 * @ExclusionPolicy("ALL")
 */
class DesignProject
{
    /**
     * ID, uuid4 format
     * @var string
     * @Expose
     * @Type("string")
     */
    private $id;
    /**
     * Name of project
     * @var string
     * @Type("string")
     * @Expose
     */
    private $name;
    /**
     * Project description
     * @var string
     * @Type("string")
     * @Expose
     */
    private $description;
    /**
     * Short information about project creator
     * @var User
     * @Type("Mutabor\Application\Adapter\User")
     * @Expose
     */
    private $owner;
    /**
     * Project interiors (rooms)
     * @var DesignInterior[]
     * @Type("array<Mutabor\Application\Adapter\DesignProject\DesignInterior>")
     * @Expose
     */
    private $interiors;

    /**
     * @param DomainDesignProject $project
     * @return DesignProject
     */
    public static function createFromDomain(DomainDesignProject $project)
    {
        $self = new self();
        $self->id = (string)$project->getId();
        $self->name = (string)$project->getName();
        $self->description = (string)$project->getDescription();
        $self->owner = User::createFromDomainUser($project->getOwner());
        
        $interiors = [];
        foreach ($project->getInteriors() as $interior) {
            $interiors[] = DesignInterior::createFromDomain($interior);
        }
        $self->interiors = $interiors;
        
        return $self;
    }

    /**
     * @return User
     */
    public function getOwner() : User
    {
        return $this->owner;
    }
}