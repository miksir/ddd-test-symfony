<?php


namespace Mutabor\Persistence\Doctrine\User;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Mutabor\Domain\Model\User\Email;
use Mutabor\Persistence\Doctrine\Doctrine\DoctrineVOTrait;

class DoctrineEmail extends StringType
{
    use DoctrineVOTrait;

    /**
     * Class name of VO
     * @return string
     */
    protected function getVOClassName()
    {
        return Email::class;
    }

    /**
     * Property inside VO to set value
     * @return string
     */
    protected function getVOPropertyName()
    {
        return 'email';
    }
}