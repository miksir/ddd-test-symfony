<?php


namespace Mutabor\Domain\Validation;


use Mutabor\Domain\Exception\DomainException;

abstract class ValidationSummaryException extends DomainException
{
    protected $errorSummary = [];

    public function __construct(string $message, array $errorSummary = [])
    {
        $this->errorSummary = $errorSummary;
        parent::__construct($message);
    }

    public function addErrors($errors)
    {
        $this->errorSummary = array_merge($this->errorSummary, $errors);
    }

    public function errorSummary() : array 
    {
        return $this->errorSummary;
    }
}