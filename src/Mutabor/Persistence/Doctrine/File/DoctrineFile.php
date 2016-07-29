<?php


namespace Mutabor\Persistence\Doctrine\File;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonArrayType;
use Mutabor\Domain\VO\File\File;

class DoctrineFile extends JsonArrayType
{

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof File) {
            $value = $this->instanceToArray($value);
        }

        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param File $value
     * @return array
     */
    protected function instanceToArray($value)
    {
        return [
            'name' => $value->getName(),
            'size' => $value->getSize(),
            'hash' => $value->getHash(),
            'mime' => $value->getMime()
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return array();
        }

        $value = (is_resource($value)) ? stream_get_contents($value) : $value;

        $array = json_decode($value, true);

        return $this->arrayToInstance($array);
    }

    /**
     * @param $array
     * @return File
     */
    protected function arrayToInstance($array)
    {
        $reflectClass = new \ReflectionClass($this->className());
        /** @var File $object */
        $object = $reflectClass->newInstanceWithoutConstructor();
        $this->initProperties($reflectClass, $object, $array);        
        return $object;
    }

    /**
     * @param \ReflectionClass $reflectClass
     * @param File $object
     * @param $array
     */
    protected function initProperties($reflectClass, $object, $array)
    {
        $this->setProperty($reflectClass, $object, 'name', $array['name']);
        $this->setProperty($reflectClass, $object, 'size', $array['size']);
        $this->setProperty($reflectClass, $object, 'hash', $array['hash']);
        $this->setProperty($reflectClass, $object, 'mime', $array['mime']);
    }
    
    protected function className()
    {
        return File::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return preg_replace('/^.*\\\\/', '', $this->className());
    }

    protected function setProperty(\ReflectionClass $class, $object, $property, $value)
    {
        $prop = $class->getProperty($property);
        $prop->setAccessible(true);
        $prop->setValue($object, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}