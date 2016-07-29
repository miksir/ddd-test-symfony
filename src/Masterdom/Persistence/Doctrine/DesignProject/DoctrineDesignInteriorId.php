<?php


namespace Masterdom\Persistence\Doctrine\DesignProject;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Masterdom\Domain\Model\DesignProject\DesignInteriorId;
use Masterdom\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

class DoctrineDesignInteriorId extends GuidType
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return DesignInteriorId::class;
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
