<?php


namespace Masterdom\Persistence\Doctrine\DesignProject;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Masterdom\Domain\Model\DesignProject\DesignProjectId;
use Masterdom\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

class DoctrineDesignProjectId extends GuidType
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return DesignProjectId::class;
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
