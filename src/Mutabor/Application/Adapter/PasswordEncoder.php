<?php


namespace Mutabor\Application\Adapter;


use Mutabor\Domain\Model\User\HashedPassword;
use Mutabor\Domain\Model\User\Password;
use Mutabor\Domain\Model\User\PasswordHashing;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoder implements PasswordHashing
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoderInterface;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->userPasswordEncoderInterface = $userPasswordEncoderInterface;
    }

    public function encodePassword(Password $raw) : HashedPassword
    {
        return new HashedPassword($this->userPasswordEncoderInterface->encodePassword(new FakeUser(), $raw));
    }

    public function isPasswordValid(HashedPassword $encoded, Password $raw) : bool
    {
        return $this->userPasswordEncoderInterface->isPasswordValid(new FakeUser($encoded), $raw);
    }
}