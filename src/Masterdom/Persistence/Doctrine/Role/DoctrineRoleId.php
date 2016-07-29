<?php


namespace Masterdom\Persistence\Doctrine\Role;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Masterdom\Domain\Model\Role\RoleId;
use Masterdom\Persistence\Doctrine\Doctrine\DoctrineVOTrait;


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
