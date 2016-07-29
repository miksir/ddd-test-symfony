<?php


namespace Mutabor\Persistence\Doctrine\User;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Mutabor\Domain\Model\User\FullName;

class DoctrineFullName extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof FullName) {
            $str = $value->getLastName() . ', ' . $value->getFirstName();
        } else {
            $str = (string)$value;
        }
        return $str;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $arr = explode(', ', $value);
        
        $reflectClass = new \ReflectionClass(FullName::class);
        $object = $reflectClass->newInstanceWithoutConstructor();

        $firstname = $reflectClass->getProperty('firstname');
        $firstname->setAccessible(true);
        $firstname->setValue($object, $arr[1] ?? '');

        $lastname = $reflectClass->getProperty('lastname');
        $lastname->setAccessible(true);
        $lastname->setValue($object, $arr[0]);
        
        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return preg_replace('/^.*\\\\/', '', FullName::class);
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}