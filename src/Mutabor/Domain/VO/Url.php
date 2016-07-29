<?php


namespace Mutabor\Domain\VO;


class Url implements ValueObject
{
    /**
     * @var string
     */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function __toString() : string
    {
        return $this->url;
    }

    public function equals(Url $object) : bool
    {
        return (string)$this === (string)$object;
    }
}