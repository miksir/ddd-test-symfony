<?php


namespace Masterdom\Domain\Model\DesignPhoto;


use Masterdom\Domain\Adapter\ObjectCollection;

class DesignPhotoCollection extends ObjectCollection
{
    public function __construct(array $elements = array())
    {
        parent::__construct(DesignPhoto::class, $elements);
    }

}