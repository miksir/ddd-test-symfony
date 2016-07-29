<?php


namespace Mutabor\Application\Adapter;


use Mutabor\Application\DTO\UserCreateRequest;
use Mutabor\Application\DTO\UserUpdateRequest;
use Mutabor\Domain\Service\User\UserRegisterService as DomainUserRegisterService;

class UserRegisterService
{
    /**
     * @var DomainUserRegisterService
     */
    private $userService;

    public function __construct(DomainUserRegisterService $userService)
    {
        $this->userService = $userService;
    }
    
    public function register(UserCreateRequest $request) : User
    {
        $user = $this->userService->register($request);
        return User::createFromDomainUser($user);
    }

    public function edit(string $id, UserUpdateRequest $request) : User
    {
        $user = $this->userService->edit($id, $request);
        return User::createFromDomainUser($user);
    }
}