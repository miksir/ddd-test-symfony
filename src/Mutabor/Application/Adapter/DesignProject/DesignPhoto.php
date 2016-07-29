<?php


namespace Mutabor\Application\Adapter\DesignProject;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Mutabor\Domain\Model\DesignPhoto\DesignPhoto as DomainDesignPhoto;

/**
 * @ExclusionPolicy("ALL")
 */
class DesignPhoto
{
    /**
     * ID, uuid4 format
     * @var string
     * @Expose
     * @Type("string")
     */
    private $id;
    /**
     * URL of photo
     * @var string
     * @Expose
     * @Type("string")
     */
    private $url;
    /**
     * @var int
     * @Expose
     * @Type("integer")
     */
    private $width;
    /**
     * @var int
     * @Expose
     * @Type("integer")
     */
    private $height;
    /**
     * @var array
     * @Expose
     * @Type("array")
     */
    private $products = [];

    public static function createFromDomain(DomainDesignPhoto $photo)
    {
        $self = new self;
        $self->id = (string)$photo->getId();
        $self->url = (string)$photo->getUrl();
        $self->width = (int)$photo->getWidth();
        $self->height = (int)$photo->getHeight();
        return $self;
    }
}