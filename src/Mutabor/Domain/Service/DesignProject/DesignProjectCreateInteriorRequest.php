<?php


namespace Mutabor\Domain\Service\DesignProject;


use Mutabor\Domain\Adapter\ArrayCollection;

interface DesignProjectCreateInteriorRequest
{
    public function getId() : string;
    
    public function getTitle() : string;
    
    public function getDescription() : string;

    public function getRoomId() : string;

    public function getDesignStyleId() : string;

    /**
     * @return ArrayCollection|DesignProjectInteriorPhotosRequest[]
     */
    public function getPhotos() : ArrayCollection;
}