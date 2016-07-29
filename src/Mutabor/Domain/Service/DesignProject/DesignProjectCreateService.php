<?php


namespace Mutabor\Domain\Service\DesignProject;


use Mutabor\Domain\Model\DesignPhoto\DesignPhoto;
use Mutabor\Domain\Model\DesignPhoto\DesignPhotoId;
use Mutabor\Domain\Model\DesignPhoto\DesignPhotoRepository;
use Mutabor\Domain\Model\DesignProject\DesignInterior;
use Mutabor\Domain\Model\DesignProject\DesignInteriorId;
use Mutabor\Domain\Model\DesignProject\DesignProject;
use Mutabor\Domain\Model\DesignProject\DesignProjectDoesNotExistException;
use Mutabor\Domain\Model\DesignProject\DesignProjectFabric;
use Mutabor\Domain\Model\DesignProject\DesignProjectId;
use Mutabor\Domain\Model\DesignProject\DesignProjectRepository;
use Mutabor\Domain\Model\DesignStyle\DesignStyleId;
use Mutabor\Domain\Model\DesignStyle\DesignStyleRepository;
use Mutabor\Domain\Model\Room\Room;
use Mutabor\Domain\Model\Room\RoomDoesNotExistException;
use Mutabor\Domain\Model\Room\RoomId;
use Mutabor\Domain\Model\Room\RoomRepository;
use Mutabor\Domain\Model\User\UserDoesNotExistException;
use Mutabor\Domain\Model\User\UserId;
use Mutabor\Domain\Model\User\UserRepository;
use Mutabor\Domain\Model\DesignPhoto\DesignPhotoCollection;
use Mutabor\Domain\Validation\AddError;
use Mutabor\Domain\Validation\FieldError;
use Mutabor\Domain\Validation\ValidationSandbox;
use Mutabor\Domain\VO\SiteName;

class DesignProjectCreateService
{
    /**
     * @var DesignProjectRepository
     */
    private $projectRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ValidationSandbox
     */
    private $validationSandbox;
    /**
     * @var RoomRepository
     */
    private $roomRepository;
    /**
     * @var DesignStyleRepository
     */
    private $designStyleRepository;
    /**
     * @var DesignPhotoRepository
     */
    private $designPhotoRepository;
    /**
     * @var DesignProjectFabric
     */
    private $projectFabric;

    public function __construct(
        DesignProjectRepository $projectRepository,
        UserRepository $userRepository,
        ValidationSandbox $validationSandbox,
        RoomRepository $roomRepository,
        DesignStyleRepository $designStyleRepository,
        DesignPhotoRepository $designPhotoRepository,
        DesignProjectFabric $projectFabric
    ) {
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
        $this->validationSandbox = $validationSandbox;
        $this->roomRepository = $roomRepository;
        $this->designStyleRepository = $designStyleRepository;
        $this->designPhotoRepository = $designPhotoRepository;
        $this->projectFabric = $projectFabric;
    }

    /**
     * @param DesignProjectCreateRequest $request
     * @return DesignProject
     * @throws UserDoesNotExistException
     * @throws DesignProjectCreateException
     */
    public function create(DesignProjectCreateRequest $request)
    {
        $userId = $this->validationSandbox->run($this, function () use ($request) {
            return new UserId($request->getUserId());
        });

        $site_name = $this->validationSandbox->run($this, function () use ($request) {
            return new SiteName($request->getName());
        });

        $this->validationSandbox->checkpoint(new DesignProjectCreateException());

        $user = $this->userRepository->byId($userId);

        $projectId = $this->projectRepository->nextIdentity();

        $project = $this->projectFabric->create(
            $projectId,
            $user,
            $request->getName(),
            $request->getDescription(),
            $site_name
        );

        foreach ($request->getInteriorRequests() as $interiorRequest) {
            $interior = $this->createProjectInterior($interiorRequest, $project);
            if ($interior) {
                $project->getInteriors()->add($interior);
            }
        }

        $this->validationSandbox->checkpoint();

        $this->projectRepository->add($project);
        return $project;
    }

    /**
     * @param DesignProjectCreateInteriorRequest $interiorRequest
     * @param DesignProject $project
     * @return DesignInterior|null
     */
    private function createProjectInterior(DesignProjectCreateInteriorRequest $interiorRequest, DesignProject $project)
    {
        $interiorId = $this->validationSandbox->run($this, function () use ($interiorRequest) {
            return new DesignInteriorId($interiorRequest->getId());
        });

        $room = $this->prepareRoom($interiorRequest);

        $designStyle = $this->prepareDesignStyle($interiorRequest);

        $photos = $this->preparePhotos($interiorRequest, $project);

        if ($this->validationSandbox->hasErrors()) {
            return null;
        }

        $interior = $this->projectFabric->createInterior(
            $interiorId,
            $interiorRequest->getTitle(),
            $interiorRequest->getDescription(),
            $project,
            $room,
            $designStyle,
            new DesignPhotoCollection($photos)
        );
        foreach ($photos as $photo) {
            $photo->setDesignInterior($interior);
        }
        return $interior;
    }

    /**
     * @param DesignInterior $designInterior
     * @param DesignProjectCreateInteriorRequest $interiorRequest
     * @param DesignProject $project
     * @return DesignInterior|null
     */
    private function updateProjectInterior(DesignInterior $designInterior, DesignProjectCreateInteriorRequest $interiorRequest, DesignProject $project)
    {
        $room = $this->prepareRoom($interiorRequest);

        $designStyle = $this->prepareDesignStyle($interiorRequest);

        $photos = $this->preparePhotos($interiorRequest, $project);

        if ($this->validationSandbox->hasErrors()) {
            return null;
        }

        $designInterior->update(
            $interiorRequest->getTitle(),
            $interiorRequest->getDescription(),
            $room,
            $designStyle,
            new DesignPhotoCollection($photos)
        );
        foreach ($photos as $photo) {
            $photo->setDesignInterior($designInterior);
        }
        return $designInterior;
    }

    /**
     * @param string $projectId
     * @param DesignProjectCreateRequest $request
     * @return DesignProject
     * @throws DesignProjectCreateException
     * @throws DesignProjectDoesNotExistException
     * @throws UserDoesNotExistException
     */
    public function update(string $projectId, DesignProjectCreateRequest $request)
    {
        $userId = $this->validationSandbox->run($this, function () use ($request) {
            return new UserId($request->getUserId());
        });

        $site_name = $this->validationSandbox->run($this, function () use ($request) {
            return new SiteName($request->getName());
        });

        $projectId = $this->validationSandbox->run($this, function () use ($projectId) {
            return new DesignProjectId($projectId);
        });

        $this->validationSandbox->checkpoint(new DesignProjectCreateException());

        $project = $this->projectRepository->byId($projectId);

        $user = $this->userRepository->byId($userId);

        $interiorRequests = $request->getInteriorRequests();
        $orphanInteriors = $project->getInteriors()->filter(function ($element) use ($interiorRequests, $project) {
            /** @var DesignInterior $element */
            foreach ($interiorRequests as $interiorRequest) {
                $interiorId = $this->validationSandbox->run($this, function () use ($interiorRequest) {
                    return new DesignInteriorId($interiorRequest->getId());
                });
                if ($interiorId && $element->getId()->equals($interiorId)) {
                    // update existing
                    $this->updateProjectInterior($element, $interiorRequest, $project);
                    // end remove from request
                    $interiorRequests->removeElement($interiorRequest);
                    return false;
                }
            }
            return true;
        });

        $this->validationSandbox->checkpoint();

        foreach ($orphanInteriors as $orphanInterior) {
            $project->getInteriors()->removeElement($orphanInterior);
        }

        foreach ($interiorRequests as $interiorRequest) {
            $projectInterior = $this->createProjectInterior($interiorRequest, $project);
            $project->getInteriors()->add($projectInterior);
        }

        $this->validationSandbox->checkpoint();

        $project->update(
            $request->getName(),
            $request->getDescription(),
            $site_name
        );

        $this->projectRepository->add($project);
        return $project;
    }

    /**
     * @param DesignProjectCreateInteriorRequest $interiorRequest
     * @param DesignProject $project
     * @return \Mutabor\Domain\Model\DesignPhoto\DesignPhoto[]
     */
    private function preparePhotos(DesignProjectCreateInteriorRequest $interiorRequest, DesignProject $project)
    {
        /** @var DesignPhoto[] $photos */
        $photos = [];
        foreach ($interiorRequest->getPhotos() as $photo) {
            $photoId = $photo->getId();
            $photos[] = $this->validationSandbox->run($this, function () use ($photoId, $project) {
                $photoIdVO = new DesignPhotoId($photoId);
                try {
                    $photo = $this->designPhotoRepository->byId($photoIdVO);
                } catch (DesignProjectDoesNotExistException $e) {
                    throw new DesignProjectDoesNotExistException("Photo {$photoId} does not exists");
                }
                if (!$photo->getOwner()->getId()->equals($project->getOwner()->getId())) {
                    throw new DesignProjectDoesNotExistException("Photo {$photoId} does not belong to project owner");
                }
                return $photo;
            });
        }
        return $photos;
    }

    /**
     * @param DesignProjectCreateInteriorRequest $interiorRequest
     * @return mixed|null
     */
    private function prepareRoom(DesignProjectCreateInteriorRequest $interiorRequest)
    {
        $room = $this->validationSandbox->run($this, function () use ($interiorRequest) {
            $roomId = new RoomId($interiorRequest->getRoomId());
            return $this->roomRepository->byId($roomId);
        });
        return $room;
    }

    /**
     * @param DesignProjectCreateInteriorRequest $interiorRequest
     * @return mixed|null
     */
    private function prepareDesignStyle(DesignProjectCreateInteriorRequest $interiorRequest)
    {
        $designStyle = $this->validationSandbox->run($this, function () use ($interiorRequest) {
            $designStyleId = new DesignStyleId($interiorRequest->getDesignStyleId());
            return $this->designStyleRepository->byId($designStyleId);
        });
        return $designStyle;
    }
}