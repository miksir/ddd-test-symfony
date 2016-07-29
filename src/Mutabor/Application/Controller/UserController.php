<?php


namespace Mutabor\Application\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Mutabor\Application\Adapter\User;
use Mutabor\Application\DTO\{
    ErrorResponse, UserCreateRequest, UserIdentityRequest, UserResponse, UserUpdateRequest
};
use Mutabor\Domain\Model\User\UserDoesNotExistException;
use Mutabor\Domain\Service\User\UserFindException;
use Mutabor\Domain\Service\User\UserRegistrationException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class UserController extends RestController
{

    /**
     * @ApiDoc(
     *     resource = true,
     *     description = "Authenticate user by password",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Success",
     *         400 = "Request validation errors",
     *         403 = "User not found or password not matched",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\UserResponse",
     *              "groups" = { "Default", "identity", "fullinfo" },
     *         },
     *         400 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error400" },
     *         },
     *         403 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default" },
     *         },
     *         500 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error500" },
     *         },
     *     },
     *     input = {
     *          "class" = "Mutabor\Application\DTO\UserIdentityRequest",
     *     }
     * )
     *
     * @param Request $request
     * @param ConstraintViolationListInterface $validationErrors
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("identity", class="Mutabor\Application\DTO\UserIdentityRequest", converter="fos_rest.request_body")
     */
    public function postIdentityAction(Request $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            $view = $this->errorView(ErrorResponse::fromConstraintViolationList($validationErrors), 400);
            return $this->handleView($view);
        }
        $identity = $request->get("identity");
        if (!$identity instanceof UserIdentityRequest) {
            $view = $this->errorView(new ErrorResponse(400, "Invalid request"), 400);
            return $this->handleView($view);
        }
        try {
            $user = $this->get("app.user_login_service")->authenticate($identity->getLogin(), $identity->getPassword());
        } catch (UserDoesNotExistException $e) {
            $view = $this->errorView(new ErrorResponse(403, "User not found or password not matched"), 403);
            return $this->handleView($view);
        }

        $token = $this->get("app.security.user_token")->createToken($user, $request);

        $view = $this->view(new UserResponse($user, $token), 200, [], ['identity', 'fullinfo']);
        return $this->handleView($view);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @ApiDoc(
     *     resource = true,
     *     description = "Get information about logged in user",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Success",
     *         401 = "Authentication required (also can be wrong or expired token)",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\UserResponse",
     *              "groups" = { "Default", "fullinfo" },
     *         },
     *         401 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error401" },
     *         },
     *         500 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error500" },
     *         },
     *     }
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getIdentityAction()
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            $view = $this->errorView(new ErrorResponse(401, "Authentication required"), 401);
            return $this->handleView($view);
        }
        $view = $this->view(new UserResponse($user), 200, [], ['fullinfo']);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *     resource = true,
     *     description = "Register new user",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Success registration",
     *         400 = "Request validation errors",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\UserResponse",
     *              "groups" = { "Default", "identity", "fullinfo" },
     *         },
     *         400 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error400" },
     *         },
     *         500 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error500" },
     *         },
     *     },
     *     input = {
     *          "class" = "Mutabor\Application\DTO\UserCreateRequest",
     *          "groups" = { "Default", "post" },
     *     }
     * )
     *
     * @param Request $request
     * @param ConstraintViolationListInterface $validationErrors
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("user", class="Mutabor\Application\DTO\UserCreateRequest", converter="fos_rest.request_body")
     */
    public function postUserAction(Request $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            $view = $this->errorView(ErrorResponse::fromConstraintViolationList($validationErrors), 400);
            return $this->handleView($view);
        }
        $user = $request->get("user");
        if (!$user instanceof UserCreateRequest) {
            $view = $this->errorView(new ErrorResponse(400, "Invalid request"), 400);
            return $this->handleView($view);
        }
        try {
            $user = $this->get("app.user_register_service")->register($user);
        } catch (UserRegistrationException $e) {
            $view = $this->errorView(ErrorResponse::fromValidationSummaryException($e), 400);
            return $this->handleView($view);
        }

        $token = $this->get("app.security.user_token")->createToken($user, $request);

        $view = $this->view(new UserResponse($user, $token), 200, [], ['identity', 'fullinfo']);
        return $this->handleView($view);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @ApiDoc(
     *     resource = true,
     *     description = "Update current user information",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Registration success",
     *         401 = "Authentication required",
     *         403 = "Permission denied",
     *         404 = "User not found",
     *         400 = "Request validation errors",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\UserResponse",
     *              "groups" = { "Default", "identity", "fullinfo" },
     *         },
     *         401 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error401" },
     *         },
     *         400 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error400" },
     *         },
     *         403 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error403" },
     *         },
     *         404 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error404" },
     *         },
     *         500 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error500" },
     *         },
     *     },
     *     input = {
     *          "class" = "Mutabor\Application\DTO\UserUpdateRequest",
     *          "groups" = { "Default", "put" },
     *     }
     * )
     *
     * @param string $userid User ID uuid4
     * @param Request $request
     * @param ConstraintViolationListInterface $validationErrors
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("user", class="Mutabor\Application\DTO\UserUpdateRequest", converter="fos_rest.request_body")
     */
    public function putUserAction(string $userid, Request $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            $view = $this->errorView(ErrorResponse::fromConstraintViolationList($validationErrors), 400);
            return $this->handleView($view);
        }
        $request_user = $request->get("user");
        if (!$request_user instanceof UserUpdateRequest) {
            $view = $this->errorView(new ErrorResponse(400, "Invalid request"), 400);
            return $this->handleView($view);
        }
        /** @var UserInterface $current_user */
        $current_user = $this->getUser();
        if (!$current_user instanceof UserInterface || $current_user->getUsername() !== $userid) {
            $view = $this->errorView(new ErrorResponse(403, "You can update yourself only"), 403);
            return $this->handleView($view);
        }
        try {
            $user = $this->get("app.user_register_service")->edit($current_user->getUsername(), $request_user);
        } catch (UserDoesNotExistException $e) {
            $view = $this->errorView(new ErrorResponse(404, "User not found"), 404);
            return $this->handleView($view);
        } catch (UserRegistrationException $e) {
            $view = $this->errorView(ErrorResponse::fromValidationSummaryException($e), 400);
            return $this->handleView($view);
        }

        $token = $this->get("app.security.user_token")->createToken($user, $request);

        $view = $this->view(new UserResponse($user, $token), 200, [], ['identity', 'fullinfo']);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *     resource = true,
     *     description = "Get public information about user",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Result",
     *         404 = "User not found",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\UserResponse",
     *              "groups" = { "Default" },
     *         },
     *         404 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error404" },
     *         },
     *         500 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error500" },
     *         },
     *     }
     * )
     *
     * @param string $userid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUserAction($userid)
    {
        try {
            $user = $this->get('app.user_find_service')->findById($userid);
        } catch (UserDoesNotExistException $e) {
            $view = $this->errorView(new ErrorResponse(404, "User not found"), 404);
            return $this->handleView($view);
        } catch (UserFindException $e) {
            $view = $this->errorView(ErrorResponse::fromValidationSummaryException($e), 400);
            return $this->handleView($view);
        }

        $view_groups = [];
        $current_user = $this->getUser();
        if ($current_user instanceof UserInterface && $current_user->getUsername() === $userid) {
            $view_groups[] = 'fullinfo';
        }

        $view = $this->view(new UserResponse($user), 200, [], $view_groups);
        return $this->handleView($view);
    }
}