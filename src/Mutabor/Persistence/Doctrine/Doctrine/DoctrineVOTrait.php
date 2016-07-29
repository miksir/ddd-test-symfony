<?php


namespace Mutabor\Persistence\Doctrine\Doctrine;


use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Class DoctrineVOTrait
 * @package Mutabor\Persistence\Doctrine\Doctrine
 */
trait DoctrineVOTrait
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return is_null($value) ? null : (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }
        $reflectClass = new \ReflectionClass($this->getVOClassName());
        $object = $reflectClass->newInstanceWithoutConstructor();
        $property = $reflectClass->getProperty($this->getVOPropertyName());
        $property->setAccessible(true);
        $property->setValue($object, $value);
        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return preg_replace('/^.*\\\\/', '', $this->getVOClassName());
    }

    /**
     * Class name of VO
     * @return string
     * @throws \Exception
     */
    protected function getVOClassName()
    {
        throw new \Exception("You must override ".self::class."::getVOClassName method");
    }

    /**
     * Property inside VO to set value
     * @return string
     * @throws \Exception
     */
    protected function getVOPropertyName()
    {
        throw new \Exception("You must override ".self::class."::getVOPropertyName method");
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
    
    
}