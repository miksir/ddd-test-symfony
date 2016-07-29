<?php


namespace Mutabor\Domain\Model\DesignPhoto;


use Mutabor\Domain\Adapter\ObjectCollection;

class DesignPhotoCollection extends ObjectCollection
{
    public function __construct(array $elements = array())
    {
        parent::__construct(DesignPhoto::class, $elements);
    }

}