<?php


namespace Mutabor\Application\DTO\DesignProject;


use Mutabor\Domain\Adapter\ArrayCollection;
use Mutabor\Domain\Service\DesignProject\DesignProjectCreateInteriorRequest;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("ALL")
 */
class DesignInteriorRequest implements DesignProjectCreateInteriorRequest
{
    /**
     * Project ID, uuid4
     * @var string
     * @Type("string")
     * @Assert\Uuid(versions={4})
     * @Assert\NotBlank()
     * @Expose
     */
    private $id;
    /**
     * Title of interior
     * @var string
     * @Type("string")
     * @Assert\Length(min=1, max=255)
     * @Assert\NotBlank()
     * @Expose
     */
    private $title;
    /**
     * Description of interior
     * @var string
     * @Type("string")
     * @Expose
     */
    private $description;
    /**
     * Id (uuid4) or room type
     * @var string
     * @Type("string")
     * @Assert\NotBlank()
     * @Assert\Uuid(versions={4})
     * @Expose
     */
    private $room;
    /**
     * Array of Id (uuid4) of design style. One and only one interior can be provided
     * @var string[]
     * @Type("array<string>")
     * @Assert\NotNull()
     * @Assert\Type(type="array")
     * @Assert\Count(min=1, max=1, minMessage = "You must specify at least one interior", maxMessage = "You can provide one and only one interior")
     * @Expose
     */
    private $style;
    /**
     * Array of photo's ID
     * @var DesignPhotoWithProductsRequest[]
     * @Type("array<Mutabor\Application\DTO\DesignProject\DesignPhotoWithProductsRequest>")
     * @Assert\NotNull()
     * @Assert\Type(type="array")
     * @Assert\Count(min=1, minMessage = "You must specify at least one photo")
     * @Expose
     */
    private $photos;
    
    public function getTitle() : string
    {
        return $this->title;
    }

    public function getDescription() : string
    {
       return $this->description ?? '';
    }

    public function getId() : string
    {
        return $this->id ?? '';
    }

    public function getRoomId() : string
    {
        return $this->room;
    }

    public function getDesignStyleId() : string
    {
        return $this->style[0] ?? '';
    }

    /**
     * @return ArrayCollection|DesignPhotoWithProductsRequest[]
     */
    public function getPhotos() : ArrayCollection
    {
        return new ArrayCollection($this->photos ?? []);
    }
}