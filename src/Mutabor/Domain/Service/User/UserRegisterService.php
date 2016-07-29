<?php


namespace Mutabor\Domain\Service\User;


use Mutabor\Domain\Model\Role\Role;
use Mutabor\Domain\Model\User\{
    Email, EmailIsNotUniqueException, EmailIsUnique, FullName, HashedPassword, Password, PasswordHashing, PasswordMismatch,
    Phone, PhoneIsNotUniqueException, PhoneIsUnique, User, UserDoesNotExistException, UserId, UserRepository
};
use Mutabor\Domain\Validation\ValidationSandbox;

class UserRegisterService
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var EmailIsUnique
     */
    private $emailIsUnique;
    /**
     * @var PhoneIsUnique
     */
    private $phoneIsUnique;
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
        EmailIsUnique $emailIsUnique,
        PhoneIsUnique $phoneIsUnique,
        PasswordHashing $hashingService,
        ValidationSandbox $validationSandbox
    )
    {
        $this->repository = $repository;
        $this->emailIsUnique = $emailIsUnique;
        $this->phoneIsUnique = $phoneIsUnique;
        $this->hashingService = $hashingService;
        $this->validationSandbox = $validationSandbox;
    }

    /**
     * @param UserRequest $userRequest
     * @return User
     * @throws UserRegistrationException
     * @throws \Mutabor\Domain\Model\User\PasswordException
     */
    public function register(UserRequest $userRequest) : User
    {
        $id = $this->repository->nextIdentity();

        $email = $this->validationSandbox->run($this, function () use ($userRequest) {
            $email = new Email($userRequest->getEmail());
            $this->checkEmailUnique($email);
            return $email;
        });

        $phone = $this->validationSandbox->run($this, function () use ($userRequest) {
            $phone = new Phone($userRequest->getPhone());
            $this->checkPhoneUnique($phone);
            return $phone;
        });

        $hashed_password = $this->validationSandbox->run($this, function () use ($userRequest) {
            $password = new Password($userRequest->getPassword());
            return $this->hashingService->encodePassword($password);
        });

        $name = new FullName($userRequest->getFirstname(), $userRequest->getLastname());

        $this->validationSandbox->checkpoint(new UserRegistrationException());

        $user = User::register($id, $name, $email, $phone, $hashed_password);
        $this->repository->add($user);

        return $user;
    }

    /**
     * @param string $id
     * @param UserUpdateRequest $userRequest
     * @return \Mutabor\Domain\Model\User\User
     * @throws UserDoesNotExistException
     * @throws UserRegistrationException
     */
    public function edit(string $id, UserUpdateRequest $userRequest)
    {
        $user_id = $this->validationSandbox->run($this, function () use ($id) {
            return new UserId($id);
        });

        $this->validationSandbox->checkpoint(new UserRegistrationException());

        $user = $this->repository->byId($user_id);

        $email = $this->validationSandbox->run($this, function () use ($userRequest, $user) {
            $email = new Email($userRequest->getEmail());
            if (!$user->getEmail()->equals($email)) {
                $this->checkEmailUnique($email);
            }
            return $email;
        });

        $phone = $this->validationSandbox->run($this, function () use ($userRequest, $user) {
            $phone = new Phone($userRequest->getPhone());
            if (!$user->getPhone()->equals($phone)) {
                $this->checkPhoneUnique($phone);
            }
            return $phone;
        });

        $name = new FullName($userRequest->getFirstname(), $userRequest->getLastname());

        if ($userRequest->getPassword()) {
            /** @var HashedPassword $hashed_password */
            $hashed_password = $this->validationSandbox->run($this, function () use ($userRequest, $user) {
                $old_password = new Password($userRequest->getOldPassword());
                if (!$user->getPassword()->equals($old_password, $this->hashingService)) {
                    throw new PasswordMismatch();
                }
                $password = new Password($userRequest->getPassword());
                $hashed_password = $this->hashingService->encodePassword($password);
                return $hashed_password;
            });
        } else {
            // Leave password unchanged
            $hashed_password = $user->getPassword();
        }

        $this->validationSandbox->checkpoint();

        $user->update($name, $email, $phone, $hashed_password);
        $this->repository->add($user);

        return $user;
    }
    
    private function checkEmailUnique(Email $email)
    {
        if (!$this->emailIsUnique->isSatisfiedBy($email)) {
            throw new EmailIsNotUniqueException("Email {$email} already exists");
        }
    }

    private function checkPhoneUnique(Phone $phone)
    {
        if (!$this->phoneIsUnique->isSatisfiedBy($phone)) {
            throw new PhoneIsNotUniqueException("Phone {$phone} already exists");
        }
    }
}