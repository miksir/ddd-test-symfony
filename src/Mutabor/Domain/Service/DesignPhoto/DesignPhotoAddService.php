<?php


namespace Mutabor\Domain\Service\DesignPhoto;


use Mutabor\Domain\Model\DesignPhoto\DesignPhoto;
use Mutabor\Domain\Model\DesignPhoto\DesignPhotoRepository;
use Mutabor\Domain\Model\User\UserDoesNotExistException;
use Mutabor\Domain\Model\User\UserId;
use Mutabor\Domain\Model\User\UserRepository;
use Mutabor\Domain\Validation\AddError;
use Mutabor\Domain\Validation\FieldError;
use Mutabor\Domain\Validation\ValidationSandbox;
use Mutabor\Domain\VO\File\Image;

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