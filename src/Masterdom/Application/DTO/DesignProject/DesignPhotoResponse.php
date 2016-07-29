<?php


namespace Masterdom\Application\DTO\DesignProject;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Masterdom\Application\Adapter\DesignProject\DesignPhoto;

/**
 * @ExclusionPolicy("ALL")
 */
class DesignPhotoResponse
{
    /**
     * @var DesignPhoto
     * @Type("Masterdom\Application\Adapter\DesignProject\DesignPhoto")
     * @Expose
     */
    private $designphoto;

    public function __construct(DesignPhoto $designPhoto)
    {
        $this->designphoto = $designPhoto;
    }


}