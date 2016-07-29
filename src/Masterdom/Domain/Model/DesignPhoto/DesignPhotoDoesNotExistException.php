<?php


namespace Masterdom\Domain\Model\DesignPhoto;


use Masterdom\Domain\Validation\ValidationException;

class DesignPhotoDoesNotExistException extends ValidationException
{
    public function __construct($message = 'Photo not found')
    {
        parent::__construct($message, self::DESIGNPHOTO_NOT_EXISTS);
    }

}