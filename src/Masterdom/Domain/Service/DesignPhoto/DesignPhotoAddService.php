<?php


namespace Masterdom\Domain\Service\DesignPhoto;


use Masterdom\Domain\Model\DesignPhoto\DesignPhoto;
use Masterdom\Domain\Model\DesignPhoto\DesignPhotoRepository;
use Masterdom\Domain\Model\User\UserDoesNotExistException;
use Masterdom\Domain\Model\User\UserId;
use Masterdom\Domain\Model\User\UserRepository;
use Masterdom\Domain\Validation\AddError;
use Masterdom\Domain\Validation\FieldError;
use Masterdom\Domain\Validation\ValidationSandbox;
use Masterdom\Domain\VO\File\Image;

class DesignPhotoAddService
{
    /**
     * @var DesignPhotoRepository
     */
    private $designPhotoRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ValidationSandbox
     */
    private $validationSandbox;

    public function __construct(
        DesignPhotoRepository $designPhotoRepository,
        UserRepository $userRepository,
        ValidationSandbox $validationSandbox
    )
    {
        $this->designPhotoRepository = $designPhotoRepository;
        $this->userRepository = $userRepository;
        $this->validationSandbox = $validationSandbox;
    }
    
    /**
     * @param DesignPhotoAddRequest $request
     * @return DesignPhoto
     * @throws UserDoesNotExistException
     * @throws DesignPhotoAddException
     */
    public function add(DesignPhotoAddRequest $request) : DesignPhoto
    {
        $photoId = $this->designPhotoRepository->nextIdentity();

        $user = $this->userRepository->byId(new UserId($request->getUserId()));

        $file = $this->validationSandbox->run($this, function () use ($request) {
            return Image::fromDisk($request->getFilePath(), $request->getFileName());
        });

        $this->validationSandbox->checkpoint(new DesignPhotoAddException());

        $photo = DesignPhoto::create($photoId, $file, $user);

        $this->designPhotoRepository->add($photo);

        return $photo;
    }
}