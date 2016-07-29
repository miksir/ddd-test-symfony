<?php


namespace Mutabor\Domain\Service\User;


use Mutabor\Domain\Model\User\Email;
use Mutabor\Domain\Model\User\EmailFormatInvalidException;
use Mutabor\Domain\Model\User\Password;
use Mutabor\Domain\Model\User\PasswordHashing;
use Mutabor\Domain\Model\User\Phone;
use Mutabor\Domain\Model\User\PhoneFormatInvalidException;
use Mutabor\Domain\Model\User\User;
use Mutabor\Domain\Model\User\UserDoesNotExistException;
use Mutabor\Domain\Model\User\UserRepository;
use Mutabor\Domain\Validation\AddError;
use Mutabor\Domain\Validation\FieldError;
use Mutabor\Domain\Validation\ValidationSandbox;

class UserLoginService
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var PasswordHashing
     */
    private $hashingService;
    /**
     * @var ValidationSandbox
     */
    private $validationSandbox;


    public function __construct(
        UserRepository $repository,
        PasswordHashing $hashingService,
        ValidationSandbox $validationSandbox
    ) {
        $this->repository = $repository;
        $this->hashingService = $hashingService;
        $this->validationSandbox = $validationSandbox;
    }
    
    /**
     * @param string $username
     * @param string $password
     * @return User
     * @throws UserDoesNotExistException
     */
    public function authenticate(string $username, string $password) : User
    {
        $user = $this->findByUsername($username);
        $hashed_password = $user->getPassword();

        /** @var Password $user_password */
        $user_password = $this->validationSandbox->run($this, function () use ($password) {
            return new Password($password);
        });

        if (!$this->hashingService->isPasswordValid($hashed_password, $user_password)) {
            throw new UserDoesNotExistException();
        }

        return $user;
    }

    /**
     * @param string $username
     * @return User
     * @throws UserDoesNotExistException
     */
    private function findByUsername(string $username) : User
    {
        try {
            $email = new Email($username);
            return $this->repository->byEmail($email);
        } catch (EmailFormatInvalidException $e) {
            // not email? ignore, may be this is phone
        }

        try {
            $phone = new Phone($username);
            return $this->repository->byPhone($phone);
        } catch (PhoneFormatInvalidException $e) {

        }

        throw new UserDoesNotExistException();
    }
}