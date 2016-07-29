<?php


namespace Mutabor\Persistence\Doctrine\DesignPhoto;


use Doctrine\DBAL\Types\GuidType;
use Mutabor\Domain\Model\DesignPhoto\DesignPhotoId;
use Mutabor\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

class DoctrineDesignPhotoId extends GuidType
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return DesignPhotoId::class;
    }

    /**
     * Property inside VO to set value
     * @return string
     */
    protected function getVOPropertyName()
    {
        return 'uuid';
    }
}
