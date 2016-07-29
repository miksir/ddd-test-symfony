<?php


namespace Mutabor\Domain\Model\DesignProject;


use Mutabor\Domain\Adapter\ObjectCollection;

class DesignInteriorCollection extends ObjectCollection
{
    public function __construct(array $elements = [])
    {
        parent::__construct(DesignInterior::class, $elements);
    }

}