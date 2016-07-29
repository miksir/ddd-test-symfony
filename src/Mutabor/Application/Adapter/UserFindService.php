<?php


namespace Mutabor\Application\Adapter;

use Mutabor\Domain\Model\User\UserDoesNotExistException;
use \Mutabor\Domain\Service\User\UserFindService as DomainUserFindService;

class UserFindService
{
    /**
     * @var DomainUserFindService
     */
    private $userFindService;

    public function __construct(DomainUserFindService $userFindService)
    {
        $this->userFindService = $userFindService;
    }

    /**
     * @param string $id
     * @return User
     * @throws UserDoesNotExistException
     */
    public function findById(string $id) : User
    {
        $user = $this->userFindService->findById($id);
        return User::createFromDomainUser($user);
    }
}