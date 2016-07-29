<?php


namespace Masterdom\Domain\Model\DesignProject;


use Masterdom\Domain\Adapter\ObjectCollection;

class DesignInteriorCollection extends ObjectCollection
{
    public function __construct(array $elements = [])
    {
        parent::__construct(DesignInterior::class, $elements);
    }

}