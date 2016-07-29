<?php


namespace Mutabor\Persistence\Doctrine\Role;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Mutabor\Domain\Model\Role\RoleId;
use Mutabor\Persistence\Doctrine\Doctrine\DoctrineVOTrait;


class DoctrineRoleId extends GuidType
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return RoleId::class;
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
