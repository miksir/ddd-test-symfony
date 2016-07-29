<?php


namespace Mutabor\Domain\Adapter;


use Mutabor\Domain\Exception\DomainException;

class ObjectCollection extends ArrayCollection
{
    /**
     * @var string
     */
    protected $class;

    public function __construct(string $class, array $elements = [])
    {
        $this->class = $class;
        parent::__construct($elements);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        if (!$value instanceof $this->class) {
            throw new DomainException('Value must be instance of '.$this->class);
        }
        $this->elements[$key] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function add($value)
    {
        if (!$value instanceof $this->class) {
            throw new DomainException('Value must be instance of '.$this->class);
        }

        $this->elements[] = $value;

        return true;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }


}