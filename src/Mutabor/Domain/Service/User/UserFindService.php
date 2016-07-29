<?php


namespace Mutabor\Domain\Service\User;

use Mutabor\Domain\Model\User\User;
use Mutabor\Domain\Model\User\UserDoesNotExistException;
use Mutabor\Domain\Model\User\UserId;
use Mutabor\Domain\Model\User\UserRepository;
use Mutabor\Domain\Validation\AddError;
use Mutabor\Domain\Validation\FieldError;
use Mutabor\Domain\Validation\ValidationSandbox;

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