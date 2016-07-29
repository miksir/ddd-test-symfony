<?php


namespace Masterdom\Domain\Service\DesignProject;


use Masterdom\Domain\Validation\ValidationSummaryException;

class DesignProjectFindException extends ValidationSummaryException
{
    public function __construct($message = "Design project find fail", array $errorSummary = [])
    {
        parent::__construct($message, $errorSummary);
    }

}