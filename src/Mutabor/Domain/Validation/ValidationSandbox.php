<?php


namespace Mutabor\Domain\Validation;


class ValidationSandbox
{
    /** @var array FieldError[] */
    private $errors = [];

    /** @var null|ValidationSummaryException */
    private $exception = null;

    /**
     * @param object $object
     * @param \Closure $function
     * @return mixed|null
     */
    public function run($object, \Closure $function)
    {
        try {
            return $function->call($object);
        } catch (ValidationException $e) {
            $this->addError($e->errorField(), $e->errorCode(), $e->getMessage());
        }
        return null;
    }

    /**
     * @param string $fieldName
     * @param int $errorCode
     * @param string $message
     */
    public function addError(string $fieldName, int $errorCode, string $message)
    {
        $this->errors[] = new FieldError($errorCode, $message, $fieldName);
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function setException(ValidationSummaryException $validationSummaryException)
    {
        $this->exception = $validationSummaryException;
    }

    /**
     * @param ValidationSummaryException $validationSummaryException
     * @throws ValidationSummaryException
     */
    public function checkpoint(ValidationSummaryException $validationSummaryException = null)
    {
        if ($validationSummaryException) {
            $this->exception = $validationSummaryException;
        }

        if ($this->hasErrors()) {
            $this->exception->addErrors($this->errors);
            throw $this->exception;
        }
    }
}