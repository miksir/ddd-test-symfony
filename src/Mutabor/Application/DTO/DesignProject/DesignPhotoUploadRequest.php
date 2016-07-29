<?php


namespace Mutabor\Application\DTO\DesignProject;


use Mutabor\Domain\Service\DesignPhoto\DesignPhotoAddRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DesignPhotoUploadRequest implements DesignPhotoAddRequest
{
    /**
     * @var UploadedFile
     */
    private $file;
    /**
     * @var string
     */
    private $userId;

    public function __construct(
        UploadedFile $file,
        string $userId
    )
    {
        $this->file = $file;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUserId() : string
    {
        return $this->userId;
    }

    public function getFilePath() : string
    {
        return $this->file->getPathname();
    }

    public function getFileName() : string
    {
        return $this->file->getClientOriginalName();
    }
}