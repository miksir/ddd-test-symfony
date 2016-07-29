<?php


namespace Masterdom\Application\Adapter;

use Masterdom\Domain\Model\User\UserDoesNotExistException;
use \Masterdom\Domain\Service\User\UserFindService as DomainUserFindService;

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