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
class DesignProjectResponse
{
    /**
     * @var DesignProject
     * @Type("Masterdom\Application\Adapter\DesignProject\DesignProject")
     * @Expose
     */
    private $designproject;

    public function __construct(DesignProject $designProject)
    {
        $this->designproject = $designProject;
    }
}