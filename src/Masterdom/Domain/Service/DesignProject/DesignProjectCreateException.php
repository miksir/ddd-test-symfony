<?php


namespace Masterdom\Domain\Service\DesignProject;


use Masterdom\Domain\Validation\ValidationSummaryException;

class DesignProjectCreateException extends ValidationSummaryException
{
    public function __construct($message = "Design project validation fail", array $errorSummary = [])
    {
        parent::__construct($message, $errorSummary);
    }

}