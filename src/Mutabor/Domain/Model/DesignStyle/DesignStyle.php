<?php


namespace Mutabor\Domain\Model\DesignStyle;


use Mutabor\Domain\Model\Attribute\Attribute;

class DesignStyle extends Attribute
{
    /**
     * @return DesignStyleId
     */
    public function getId()
    {
        return $this->id;
    }
}