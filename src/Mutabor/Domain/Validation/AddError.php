<?php


namespace Mutabor\Domain\Validation;


interface AddError
{
    public function addError(string $field, int $code, string $message);
}