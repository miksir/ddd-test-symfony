<?php


namespace Mutabor\Application\Adapter;


class UserLoginService
{
    /**
     * @var \Mutabor\Domain\Service\User\UserLoginService
     */
    private $loginService;

    public function __construct(\Mutabor\Domain\Service\User\UserLoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function authenticate(string $username, string $password) : User
    {
        $user = $this->loginService->authenticate($username, $password);
        return User::createFromDomainUser($user);
    }
}