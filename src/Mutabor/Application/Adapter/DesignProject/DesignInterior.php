<?php


namespace Mutabor\Application\Adapter\DesignProject;


use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Mutabor\Domain\Model\DesignProject\DesignInterior as DomainDesignInterior;
use Mutabor\Domain\Model\Room\Room;

/**
 * @ExclusionPolicy("ALL")
 */
class DesignInterior
{
    /**
     * ID, uuid4 format
     * @var string
     * @Expose
     * @Type("string")
     */
    private $id;
    /**
     * Interior title
     * @var string
     * @Type("string")
     * @Expose
     */
    private $title;
    /**
     * Interior description
     * @var string
     * @Type("string")
     * @Expose
     */
    private $description;
    /**
     * Id of room type
     * @var string
     * @Type("string")
     * @Expose
     */
    private $room;
    /**
     * Array of Id or design style. Currently only one element will be returned (array[0])
     * @var string[]
     * @Type("array<string>")
     * @Expose
     */
    private $style;
    /**
     * Photos
     * @var DesignPhoto[]
     * @Type("array<Mutabor\Application\Adapter\DesignProject\DesignPhoto>")
     * @Expose
     */
    private $photos;

    /**
     * @param DomainDesignInterior $interior
     * @return DesignInterior
     */
    public static function createFromDomain(DomainDesignInterior $interior)
    {
        $self = new self();
        $self->id = (string)$interior->getId();
        $self->title = (string)$interior->getTitle();
        $self->description = (string)$interior->getDescription();
        $self->room = (string)$interior->getRoom()->getId();
        $self->style = [(string)$interior->getDesignStyle()->getId()];

        $photos = [];
        foreach ($interior->getDesignPhotos() as $photo) {
            $photos[] = DesignPhoto::createFromDomain($photo);
        }
        $self->photos = $photos;

        return $self;
    }
}