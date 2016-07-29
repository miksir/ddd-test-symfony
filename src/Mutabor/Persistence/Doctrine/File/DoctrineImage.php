<?php


namespace Mutabor\Persistence\Doctrine\File;


use Mutabor\Domain\VO\File\Image;

class DoctrineImage extends DoctrineFile
{
    /**
     * @param Image $value
     * @return array
     */
    protected function instanceToArray($value)
    {
        $array = parent::instanceToArray($value);
        if ($value instanceof Image) {
            return array_merge($array, [
                'width' => $value->getWidth(),
                'height' => $value->getHeight()
            ]);
        }
        return $array;
    }

    protected function className()
    {
        return Image::class;
    }

    /**
     * @param \ReflectionClass $reflectClass
     * @param Image $object
     * @param $array
     */
    protected function initProperties($reflectClass, $object, $array)
    {
        parent::initProperties($reflectClass, $object, $array);
        $this->setProperty($reflectClass, $object, 'width', $array['width']);
        $this->setProperty($reflectClass, $object, 'height', $array['height']);
    }


}