<?php


namespace Mutabor\Domain\Validation;


use Mutabor\Domain\Exception\DomainException;

abstract class ValidationException extends DomainException
{
    const PHONE_IS_NOT_UNIQUE =         ['phone', 100001];
    const EMAIL_IS_NOT_UNIQUE =         ['email', 100002];
    const EMAIL_FORMAT_INVALID =        ['email', 100003];
    const PHONE_FORMAT_INVALID =        ['phone', 100004];
    const PASSWORD_MISMATCH =           ['password', 100005];
    const ID_FORMAT_INVALID =           ['id', 100006];
    const ROOM_DOEST_NOT_EXISTS =       ['room', 100007];
    const DESIGNSTYLE_DOEST_NOT_EXISTS =['designstyle', 100008];
    const DESIGNPHOTO_NOT_EXISTS =      ['file', 100009];
    const DESIGNPHOTO_NOT_IMAGE =       ['file', 100010];
    const USER_NOT_FOUND =              ['user_id', 100011];

    /**
     * @var int
     */
    protected $errorCode;

    /**
     * @var string
     */
    protected $errorField;

    /**
     * ValidationException constructor.
     * @param string $message
     * @param array $code array[string, int]
     */
    public function __construct(string $message, array $code)
    {
        $this->errorField = (string)$code[0];
        $this->errorCode = (int)$code[1];
        parent::__construct($message);
    }

    public function errorCode() : int
    {
        return $this->errorCode;
    }
    
    public function errorField() : string
    {
        return $this->errorField;
    }
}