<?php


namespace Masterdom\Persistence\Doctrine\User;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Masterdom\Domain\Model\User\UserId;
use Masterdom\Persistence\Doctrine\Doctrine\DoctrineVOTrait;


class DoctrineUserId extends GuidType
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return UserId::class;
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
