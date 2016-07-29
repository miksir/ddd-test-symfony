<?php


namespace Masterdom\Domain\Service\DesignPhoto;


use Masterdom\Domain\Validation\ValidationSummaryException;

class DesignPhotoAddException extends ValidationSummaryException
{
    public function __construct($message = "Photo upload validation fail", array $errorSummary = [])
    {
        parent::__construct($message, $errorSummary);
    }

}