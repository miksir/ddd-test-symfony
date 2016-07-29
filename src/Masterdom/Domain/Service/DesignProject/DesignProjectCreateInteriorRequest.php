<?php


namespace Masterdom\Domain\Service\DesignProject;


use Masterdom\Domain\Adapter\ArrayCollection;

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