<?php


namespace Mutabor\Application\Adapter\DesignProject;


use Mutabor\Application\DTO\DesignProject\DesignPhotoUploadRequest;
use Mutabor\Domain\Service\DesignPhoto\DesignPhotoAddService as DomainDesignPhotoAddService;

class DesignPhotoAddService
{
    /**
     * @var DomainDesignPhotoAddService
     */
    private $designPhotoAddService;

    public function __construct(
        DomainDesignPhotoAddService $designPhotoAddService
    )
    {
        $this->designPhotoAddService = $designPhotoAddService;
    }

    /**
     * Add temporary file from POST
     * @param DesignPhotoUploadRequest $request
     * @return DesignPhoto
     */
    public function add(DesignPhotoUploadRequest $request) : DesignPhoto
    {
        $photo = $this->designPhotoAddService->add($request);
        return DesignPhoto::createFromDomain($photo);
    }
}