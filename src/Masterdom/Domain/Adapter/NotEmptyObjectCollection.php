<?php


namespace Masterdom\Domain\Adapter;


use Masterdom\Domain\Exception\DomainException;

class NotEmptyObjectCollection extends ObjectCollection
{
    public function __construct(string $class, array $elements)
    {
        if (empty($elements)) {
            throw new DomainException('Array can not be empty');
        }
        parent::__construct($class, $elements);
    }
}