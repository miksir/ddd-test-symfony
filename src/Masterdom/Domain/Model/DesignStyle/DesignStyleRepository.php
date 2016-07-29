<?php


namespace Masterdom\Domain\Model\DesignStyle;


use Masterdom\Domain\VO\SiteName;

interface DesignStyleRepository
{
    /**
     * @param DesignStyleId $id
     * @return DesignStyle
     * @throws DesignStyleDoesNotExistException
     */
    public function byId(DesignStyleId $id) : DesignStyle;

    /**
     * @param SiteName $siteName
     * @return DesignStyle
     * @throws DesignStyleDoesNotExistException
     */
    public function bySiteName(SiteName $siteName) : DesignStyle;

    /**
     * @return DesignStyle[]
     */
    public function all() : array;
}