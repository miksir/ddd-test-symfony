<?php


namespace Masterdom\Domain\Service\DesignProject;


use Masterdom\Domain\Adapter\ArrayCollection;

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