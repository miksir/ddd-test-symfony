<?php


namespace Mutabor\Domain\Service\DesignPhoto;

interface DesignPhotoAddRequest
{
    public function getFilePath() : string;
    
    public function getFileName() : string;
    
    public function getUserId() : string;
}