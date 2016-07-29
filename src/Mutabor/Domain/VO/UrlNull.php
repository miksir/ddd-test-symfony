<?php


namespace Mutabor\Domain\VO;


class UrlNull extends Url
{
    public function __construct()
    {
    }

    public function __toString() : string
    {
        return '';
    }

    public function equals(Url $object) : bool
    {
        return false;
    }
}