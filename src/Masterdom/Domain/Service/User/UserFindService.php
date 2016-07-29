<?php


namespace Masterdom\Domain\Service\User;

use Masterdom\Domain\Model\User\User;
use Masterdom\Domain\Model\User\UserDoesNotExistException;
use Masterdom\Domain\Model\User\UserId;
use Masterdom\Domain\Model\User\UserRepository;
use Masterdom\Domain\Validation\AddError;
use Masterdom\Domain\Validation\FieldError;
use Masterdom\Domain\Validation\ValidationSandbox;

class UserFindService
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var ValidationSandbox
     */
    private $validationSandbox;

    /**
     * UserFindService constructor.
     * @param UserRepository $repository
     * @param ValidationSandbox $validationSandbox
     */
    public function __construct(
        UserRepository $repository,
        ValidationSandbox $validationSandbox
    ) {
        $this->repository = $repository;
        $this->validationSandbox = $validationSandbox;
    }    
    
    /**
     * @param string $id
     * @return User
     * @throws UserDoesNotExistException
     * @throws UserFindException
     */
    public function findById(string $id) : User
    {
        $user_id = $this->validationSandbox->run($this, function () use ($id) {
            return new UserId($id);
        });

        $this->validationSandbox->checkpoint(new UserFindException());

        return $this->repository->byId($user_id);
    }
}