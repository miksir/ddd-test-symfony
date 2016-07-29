<?php


namespace Mutabor\Application\DTO;


use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Mutabor\Domain\Validation\ValidationSummaryException;
use Mutabor\Domain\Validation\FieldError;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorResponse
{
    /**
     * Always true if error message
     * @var bool
     * @Type("boolean")
     */
    private $error = true;
    /**
     * HTTP error code
     * @var int
     * @Type("integer")
     */
    private $code;
    /**
     * @var string
     * @Type("string")
     */
    private $message;
    /**
     * @var array
     * @Type("array<Mutabor\Domain\Validation\FieldError>")
     * @Groups({"error400"})
     */
    private $errors;

    public function __construct(int $code, string $message, $errors = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->errors = $errors;
    }

    public static function fromValidationSummaryException(ValidationSummaryException $e)
    {
        return new self(400, $e->getMessage(), $e->errorSummary());
    }

    /**
     * @param ConstraintViolationListInterface|ConstraintViolationInterface[] $violationList
     * @return ErrorResponse
     */
    public static function fromConstraintViolationList(ConstraintViolationListInterface $violationList)
    {
        $errors = [];
        foreach ($violationList as $violation) {
            $errors[] = new FieldError(0, $violation->getMessage(), $violation->getPropertyPath());
        }
        return new self(400, "Input validation error", $errors);
    }
}