<?php


namespace Mutabor\Domain\Service\DesignProject;


use Mutabor\Domain\Validation\ValidationSummaryException;

class DesignProjectFindException extends ValidationSummaryException
{
    public function __construct($message = "Design project find fail", array $errorSummary = [])
    {
        parent::__construct($message, $errorSummary);
    }

}