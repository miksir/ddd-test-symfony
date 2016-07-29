<?php


namespace Mutabor\Domain\VO;


use Mutabor\Domain\Exception\IdFormatInvalidException;

abstract class UuidValueObject
{
    protected $uuid;

    public function __construct(string $uuid)
    {
        if (!preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid)) {
            throw new IdFormatInvalidException();
        }
        $this->uuid = $uuid;
    }

    public function __toString() : string
    {
        return $this->uuid;
    }
}