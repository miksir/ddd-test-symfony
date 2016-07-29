<?php


namespace Mutabor\Persistence\Doctrine\DesignPhoto;


use Mutabor\Domain\Model\DesignPhoto\DesignPhoto;
use Mutabor\Domain\VO\File\File;

abstract class DoctrineDesignPhotoFileStorage
{
    abstract public function save(DesignPhoto $photo, File $file);
    
    abstract protected function getUrl(DesignPhoto $photo, File $file);
    
    public function load(DesignPhoto $photo, File $file) 
    {
        $url = $this->getUrl($photo, $file);
        
        $class = new \ReflectionClass($file);
        $prop = $class->getProperty('path');
        $prop->setAccessible(true);
        $prop->setValue($file, $url);
    }
}