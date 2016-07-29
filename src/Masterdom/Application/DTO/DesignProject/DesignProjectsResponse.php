<?php


namespace Masterdom\Application\DTO\DesignProject;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Masterdom\Application\Adapter\DesignProject\DesignProject;

/**
 * @ExclusionPolicy("ALL")
 */
class DesignProjectsResponse
{
    /**
     * @var DesignProject
     * @Type("array<Masterdom\Application\Adapter\DesignProject\DesignProject>")
     * @Expose
     */
    private $designprojects;

    /**
     * DesignProjectsResponse constructor.
     * @param DesignProject[] $projects
     */
    public function __construct(array $projects)
    {
        $this->designprojects = $projects;
    }

}