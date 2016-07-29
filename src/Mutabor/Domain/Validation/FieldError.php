<?php


namespace Mutabor\Domain\Validation;


class FieldError
{
    /**
     * Internal error code
     * @var int
     */
    private $code;
    /**
     * @var string
     */
    private $message;
    /**
     * Name of validated field
     * @var string
     */
    private $field;

    public function __construct(int $code, string $message, string $field)
    {
        $this->code = $code;
        $this->message = $message;
        $this->field = $field;
    }

}