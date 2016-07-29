<?php


namespace Masterdom\Domain\Model\DesignStyle;


use Masterdom\Domain\Model\Attribute\Attribute;

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