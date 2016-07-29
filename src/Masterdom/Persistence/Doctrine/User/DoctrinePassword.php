<?php


namespace Masterdom\Persistence\Doctrine\User;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Masterdom\Domain\Model\User\HashedPassword;
use Masterdom\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

class DoctrinePassword extends StringType
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return HashedPassword::class;
    }

    /**
     * Property inside VO to set value
     * @return string
     */
    protected function getVOPropertyName()
    {
        return 'password';
    }
}