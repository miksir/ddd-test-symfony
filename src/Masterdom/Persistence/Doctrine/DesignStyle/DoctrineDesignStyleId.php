<?php


namespace Masterdom\Persistence\Doctrine\DesignStyle;


use Doctrine\DBAL\Types\GuidType;
use Masterdom\Domain\Model\DesignStyle\DesignStyleId;
use Masterdom\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

class DoctrineDesignStyleId extends GuidType
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return DesignStyleId::class;
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