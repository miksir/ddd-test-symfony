<?php


namespace Mutabor\Domain\Service\DesignProject;


use Mutabor\Domain\Validation\ValidationSummaryException;

class DesignProjectCreateException extends ValidationSummaryException
{
    public function __construct($message = "Design project validation fail", array $errorSummary = [])
    {
        parent::__construct($message, $errorSummary);
    }

}