<?php


namespace Masterdom\Persistence\Doctrine\DesignPhoto;


use Doctrine\DBAL\Types\GuidType;
use Masterdom\Domain\Model\DesignPhoto\DesignPhotoId;
use Masterdom\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

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
