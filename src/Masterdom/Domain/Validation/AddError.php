<?php


namespace Masterdom\Domain\Validation;


interface AddError
{
    public function addError(string $field, int $code, string $message);
}