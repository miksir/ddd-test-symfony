<?php


namespace Mutabor\Domain\Model\User;


use Mutabor\Domain\VO\ValueObject;

/**
 * Class Phone
 * Russian phone format
 * @package Mutabor\Domain\Model\User
 */
class Phone implements ValueObject
{
    private $phone;

    public function __construct(string $phone)
    {
        $this->phone = $phone ? $this->cleanPhone($phone) : '';
    }

    private function cleanPhone(string $phone)
    {
        $absolute = $phone[0] === '+';
        $numbers = preg_replace('/\D/', '', $phone);

        if (!$numbers) {
            throw new PhoneFormatInvalidException();
        }

        // special logic for russian local phone notation
        if ($numbers[0] === '8' && !$absolute && strlen($numbers) == 11) {
            $numbers[0] = '7';
        }

        if ($numbers[0] !== '7' || strlen($numbers) != 11) {
            throw new PhoneFormatInvalidException();
        }

        return $numbers;
    }

    public function __toString() : string
    {
        return $this->phone;
    }

    public function equals(Phone $object) : bool
    {
        return (string)$this === (string)$object;
    }
}