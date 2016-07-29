<?php


namespace Mutabor\Domain\Model\Attribute;


use Mutabor\Domain\VO\SiteName;

abstract class Attribute
{
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var SiteName
     */
    protected $siteName;
    /**
     * @var int
     */
    protected $type;

    protected function __construct()
    {

    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return SiteName
     */
    public function getSiteName() : SiteName
    {
        return $this->siteName;
    }
}