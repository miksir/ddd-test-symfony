<?php


namespace Mutabor\Application\Security;


use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use Mutabor\Application\Adapter\User;
use Mutabor\Application\DTO\ErrorResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class UserAuthenticate extends AbstractGuardAuthenticator
{
    /**
     * @var UserSecurityToken
     */
    private $securityTokenService;

    /**
     * @var Request
     */
    private $request;
    /**
     * @var ViewHandlerInterface
     */
    private $viewHandlerInterface;

    public function __construct(UserSecurityToken $securityTokenService, ViewHandlerInterface $viewHandlerInterface)
    {
        $this->securityTokenService = $securityTokenService;
        $this->viewHandlerInterface = $viewHandlerInterface;
    }


    /**
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials(Request $request)
    {
        $this->request = $request;
        $token = $request->headers->get('X-AUTH-TOKEN'); // ?? $request->cookies->get('token');

        return $token ? [ 'token' => $token ] : null;
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * You may throw an AuthenticationException if you wish. If you return
     * null, then a UsernameNotFoundException is thrown for you.
     *
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user_id = $this->securityTokenService->extractUserId($this->request, $credentials['token']);
        try {
            if (!$user_id) {
                throw new UsernameNotFoundException();
            }
            $user = $userProvider->loadUserByUsername($user_id);
        } catch (UsernameNotFoundException $e) {
            throw new AuthenticationException("Invalid or expired token");
        }
        return $user;
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new AuthenticationException("Wrong user class");
        }
        if (!$this->securityTokenService->validateToken($user, $this->request, $credentials['token'])) {
            throw new AuthenticationException("Invalid or expired token");
        }
        return true;
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        /** @TODO Хм, а если аутентификация не нужна? */
        return $this->errorResponse('Authentication required', 401);
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * Does this method support remember me cookies?
     *
     * Remember me cookie will be set if *all* of the following are met:
     *  A) This method returns true
     *  B) The remember_me key under your firewall is configured
     *  C) The "remember me" functionality is activated. This is usually
     *      done by having a _remember_me checkbox in your form, but
     *      can be configured by the "always_remember_me" and "remember_me_parameter"
     *      parameters under the "remember_me" firewall key
     *
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param AuthenticationException $authException The exception that started the authentication process
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return $this->errorResponse('Authentication required', 401);
    }
    
    private function errorResponse($message, $code)
    {
        return $this->viewHandlerInterface->handle(View::create(new ErrorResponse($code, $message), $code));
    }
}