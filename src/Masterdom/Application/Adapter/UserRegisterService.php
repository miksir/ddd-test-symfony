<?php


namespace Masterdom\Application\Adapter;


use Masterdom\Application\DTO\UserCreateRequest;
use Masterdom\Application\DTO\UserUpdateRequest;
use Masterdom\Domain\Service\User\UserRegisterService as DomainUserRegisterService;

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