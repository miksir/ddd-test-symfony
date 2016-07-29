<?php


namespace Mutabor\Application\Controller;

use Mutabor\Application\DTO\DesignProject\DesignPhotoResponse;
use Mutabor\Application\DTO\DesignProject\DesignPhotoUploadRequest;
use Mutabor\Application\DTO\DesignProject\DesignProjectRequest;
use Mutabor\Application\DTO\DesignProject\DesignProjectResponse;
use Mutabor\Application\DTO\DesignProject\DesignProjectsResponse;
use Mutabor\Application\DTO\ErrorResponse;
use Mutabor\Domain\Model\DesignProject\DesignProjectDoesNotExistException;
use Mutabor\Domain\Model\User\UserDoesNotExistException;
use Mutabor\Domain\Service\DesignPhoto\DesignPhotoAddException;
use Mutabor\Domain\Service\DesignProject\DesignProjectCreateException;
use Mutabor\Domain\Service\DesignProject\DesignProjectFindException;
use Mutabor\Domain\Service\User\UserFindException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;


class DesignProjectController extends RestController
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @ApiDoc(
     *     resource = true,
     *     description = "Create design project",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Success",
     *         400 = "Request validation errors",
     *         401 = "Authentication required",
     *         403 = "Permission denied",
     *         404 = "User not found",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\DesignProject\DesignProjectResponse",
     *              "groups" = { "Default" },
     *         },
     *         400 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error400" },
     *         },
     *         401 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error401" },
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
     *          "class" = "Mutabor\Application\DTO\DesignProject\DesignProjectRequest",
     *          "groups" = { "Default", "post" },
     *     }
     * )
     * @param string $userid User ID, uuid4
     * @param Request $request
     * @param ConstraintViolationListInterface $validationErrors
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("project", class="Mutabor\Application\DTO\DesignProject\DesignProjectRequest", converter="fos_rest.request_body")
     */
    public function postDesignprojectAction(string $userid, Request $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            $view = $this->errorView(ErrorResponse::fromConstraintViolationList($validationErrors), 400);
            return $this->handleView($view);
        }
        /** @var UserInterface $current_user */
        $current_user = $this->getUser();
        if (!$current_user instanceof UserInterface || $current_user->getUsername() !== $userid) {
            $view = $this->errorView(new ErrorResponse(403, "You can update yourself only"), 403);
            return $this->handleView($view);
        }
        $project = $request->get("project");
        if (!$project instanceof DesignProjectRequest) {
            $view = $this->errorView(new ErrorResponse(400, "Invalid request"), 400);
            return $this->handleView($view);
        }
        try {
            $created_project = $this->get('app.designproject_create_service')->create($userid, $project);
        } catch (UserDoesNotExistException $e) {
            $view = $this->errorView(new ErrorResponse(404, "User not found"), 404);
            return $this->handleView($view);
        } catch (DesignProjectCreateException $e) {
            $view = $this->errorView(ErrorResponse::fromValidationSummaryException($e), 400);
            return $this->handleView($view);
        }

        $view = $this->view(new DesignProjectResponse($created_project), 200, [], []);
        return $this->handleView($view);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @ApiDoc(
     *     resource = true,
     *     description = "Update design project",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Success",
     *         400 = "Request validation errors",
     *         401 = "Authentication required",
     *         403 = "Permission denied",
     *         404 = "User not found",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\DesignProject\DesignProjectResponse",
     *              "groups" = { "Default" },
     *         },
     *         400 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error400" },
     *         },
     *         401 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error401" },
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
     *          "class" = "Mutabor\Application\DTO\DesignProject\DesignProjectRequest",
     *          "groups" = { "Default", "put" },
     *     }
     * )
     * @param string $userid User ID, uuid4
     * @param string $projectid User ID, uuid4
     * @param Request $request
     * @param ConstraintViolationListInterface $validationErrors
     * @return \Symfony\Component\HttpFoundation\Response
     * @ParamConverter("project", class="Mutabor\Application\DTO\DesignProject\DesignProjectRequest", converter="fos_rest.request_body")
     */
    public function putDesignprojectAction(string $userid, string $projectid, Request $request, ConstraintViolationListInterface $validationErrors)
    {
        if (count($validationErrors) > 0) {
            $view = $this->errorView(ErrorResponse::fromConstraintViolationList($validationErrors), 400);
            return $this->handleView($view);
        }
        /** @var UserInterface $current_user */
        $current_user = $this->getUser();
        if (!$current_user instanceof UserInterface || $current_user->getUsername() !== $userid) {
            $view = $this->errorView(new ErrorResponse(403, "You can update yourself only"), 403);
            return $this->handleView($view);
        }
        $project = $request->get("project");
        if (!$project instanceof DesignProjectRequest) {
            $view = $this->errorView(new ErrorResponse(400, "Invalid request"), 400);
            return $this->handleView($view);
        }
        try {
            $created_project = $this->get('app.designproject_create_service')->update($userid, $projectid, $project);
        } catch (UserDoesNotExistException $e) {
            $view = $this->errorView(new ErrorResponse(404, "User not found"), 404);
            return $this->handleView($view);
        } catch (DesignProjectDoesNotExistException $e) {
            $view = $this->errorView(new ErrorResponse(404, "Project not found"), 404);
            return $this->handleView($view);
        } catch (DesignProjectCreateException $e) {
            $view = $this->errorView(ErrorResponse::fromValidationSummaryException($e), 400);
            return $this->handleView($view);
        }

        $view = $this->view(new DesignProjectResponse($created_project), 200, [], []);
        return $this->handleView($view);
    }
    
    /**
     * @ApiDoc(
     *     resource = true,
     *     description = "List user projects",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Success",
     *         400 = "Request validation errors",
     *         404 = "User not found",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\DesignProject\DesignProjectsResponse",
     *              "groups" = { "Default" },
     *         },
     *         400 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error400" },
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
     * @param string $userid User ID, uuid4
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDesignprojectsAction(string $userid)
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

        try {
            $projects = $this->get('app.designproject_find_service')->findByUserId($userid);
        } catch (DesignProjectFindException $e) {
            $view = $this->errorView(ErrorResponse::fromValidationSummaryException($e), 400);
            return $this->handleView($view);
        }

        $view = $this->view(new DesignProjectsResponse($projects), 200, [], []);
        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *     resource = true,
     *     description = "Show specified project",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Success",
     *         400 = "Request validation errors",
     *         404 = "User or project not found or user and project owner mismatch",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\DesignProject\DesignProjectResponse",
     *              "groups" = { "Default" },
     *         },
     *         400 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error400" },
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
     * @param string $userid User ID, uuid4
     * @param string $projectid Project ID, uuid4
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDesignprojectAction(string $userid, string $projectid)
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

        try {
            $project = $this->get('app.designproject_find_service')->findById($projectid);
        } catch (DesignProjectDoesNotExistException $e) {
            $view = $this->errorView(new ErrorResponse(404, "Project not found"), 404);
            return $this->handleView($view);
        } catch (DesignProjectFindException $e) {
            $view = $this->errorView(ErrorResponse::fromValidationSummaryException($e), 400);
            return $this->handleView($view);
        }

        if ($user->getUsername() !== $project->getOwner()->getUsername()) {
            $view = $this->errorView(new ErrorResponse(404, "Project do not belong to user"), 404);
            return $this->handleView($view);
        }

        $view = $this->view(new DesignProjectResponse($project), 200, [], []);
        return $this->handleView($view);
    }

    /**
     * @Security("has_role('ROLE_USER')")
     * @ApiDoc(
     *     resource = true,
     *     description = "Temporary upload photo. You can use ID of this photo with add project request",
     *     views = { "rest" },
     *     statusCodes = {
     *         200 = "Success",
     *         400 = "Request validation errors",
     *         401 = "Authentication required",
     *         403 = "Permission denied",
     *         404 = "User not found",
     *         500 = "Server fatal error",
     *     },
     *     responseMap = {
     *         200 = {
     *              "class" = "Mutabor\Application\DTO\DesignProject\DesignPhotoResponse",
     *              "groups" = { "Default" },
     *         },
     *         400 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error400" },
     *         },
     *         401 = {
     *              "class" = "Mutabor\Application\DTO\ErrorResponse",
     *              "groups" = { "Default", "error401" },
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
     *     parameters = {
     *         { "name" = "file", "dataType" = "file", "required" = true, "description" = "File" }
     *     }
     * )
     * @param string $userid User ID, uuid4
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postDesignprojectPhotosAction(string $userid, Request $request)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        if (!$file) {
            $view = $this->errorView(new ErrorResponse(400, "Can't find file in POST"), 400);
            return $this->handleView($view);
        }

        /** @var UserInterface $current_user */
        $current_user = $this->getUser();
        if (!$current_user instanceof UserInterface || $current_user->getUsername() !== $userid) {
            $view = $this->errorView(new ErrorResponse(403, "You can update yourself only"), 403);
            return $this->handleView($view);
        }

        try {
            $request = new DesignPhotoUploadRequest($file, $userid);
            $photo = $this->get('app.designphoto_add_service')->add($request);
        } catch (DesignPhotoAddException $e) {
            $view = $this->errorView(ErrorResponse::fromValidationSummaryException($e), 400);
            return $this->handleView($view);
        }

        $view = $this->view(new DesignPhotoResponse($photo), 200, [], []);
        return $this->handleView($view);
    }
}