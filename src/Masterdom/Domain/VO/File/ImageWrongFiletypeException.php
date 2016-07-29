<?php


namespace Masterdom\Domain\VO\File;


use Masterdom\Domain\Validation\ValidationException;

class ImageWrongFiletypeException extends ValidationException
{
    public function __construct($message = "File is not valid image")
    {
        parent::__construct($message, self::DESIGNPHOTO_NOT_IMAGE);
    }

}