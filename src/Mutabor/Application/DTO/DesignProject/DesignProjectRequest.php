<?php


namespace Mutabor\Application\DTO\DesignProject;


use Mutabor\Application\DTO\DesignProject\DesignInteriorRequest;
use Mutabor\Domain\Adapter\ArrayCollection;
use Mutabor\Domain\Service\DesignProject\DesignProjectCreateInteriorRequest;
use Mutabor\Domain\Service\DesignProject\DesignProjectCreateRequest;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("ALL")
 */
class DesignProjectRequest implements DesignProjectCreateRequest
{
    private $id;
    /**
     * Name of project
     * @var string
     * @Type("string")
     * @Assert\Length(min=1, max=255)
     * @Assert\NotBlank()
     * @Expose
     */
    private $name;
    /**
     * Description of project
     * @var string
     * @Type("string")
     * @Expose
     */
    private $description;
    /**
     * @var string
     */
    private $user_id;
    /**
     * Interiors list
     * @var DesignInteriorRequest[]
     * @Type("array<Mutabor\Application\DTO\DesignProject\DesignInteriorRequest>")
     * @Assert\NotNull()
     * @Assert\Type(type="array")
     * @Assert\Count(min=1, minMessage = "You must specify at least one interior")
     * @Expose
     */
    private $interiors;


    public function getName() : string
    {
        return $this->name;
    }

    public function getDescription() : string
    {
        return $this->description ?? '';
    }

    public function getUserId() : string
    {
        return $this->user_id;
    }

    /**
     * @return ArrayCollection|DesignProjectCreateInteriorRequest[]
     */
    public function getInteriorRequests() : ArrayCollection
    {
        return new ArrayCollection($this->interiors ?? []);
    }

    /**
     * @param string $user_id
     */
    public function setUserId(string $user_id)
    {
        $this->user_id = $user_id;
    }
}