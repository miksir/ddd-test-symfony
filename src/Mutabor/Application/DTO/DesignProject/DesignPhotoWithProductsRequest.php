<?php


namespace Mutabor\Application\DTO\DesignProject;

use JMS\Serializer\Annotation\Type;
use Mutabor\Domain\Service\DesignProject\DesignProjectInteriorPhotosRequest;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("ALL")
 */
class DesignPhotoWithProductsRequest implements DesignProjectInteriorPhotosRequest
{
    /**
     * Project ID, uuid4
     * @var string
     * @Type("string")
     * @Assert\Uuid(versions={4})
     * @Expose
     */
    private $id;
    /**
     * Empty array
     * @var string[]
     * @Type("array<string>")
     * @Assert\Type(type="array")
     * @Assert\Count(max=0, maxMessage = "Not supported yet")
     * @Expose
     */
    private $products;

    /**
     * @return mixed
     */
    public function getId() : string
    {
        return $this->id;
    }
}