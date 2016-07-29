<?php


namespace Mutabor\Domain\Service\DesignProject;


use Mutabor\Domain\Adapter\ArrayCollection;

interface DesignProjectCreateRequest
{
    public function getName() : string;
    
    public function getDescription() : string;
    
    public function getUserId() : string;

    /**
     * @return ArrayCollection|DesignProjectCreateInteriorRequest[]
     */
    public function getInteriorRequests() : ArrayCollection;
}