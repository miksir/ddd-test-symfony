<?php


namespace Mutabor\Persistence\Doctrine\DesignPhoto;


use Mutabor\Domain\Model\DesignPhoto\DesignPhoto;
use Mutabor\Domain\VO\File\File;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser;

class DoctrineDesignPhotoFileStorageDisk extends DoctrineDesignPhotoFileStorage
{
    /**
     * @var string
     */
    private $upload_directory;
    /**
     * @var MimeTypeExtensionGuesser
     */
    private $mimeTypeGuesser;

    public function __construct(
        $upload_directory,
        MimeTypeExtensionGuesser $mimeTypeGuesser
    )
    {
        $this->upload_directory = $upload_directory;
        $this->mimeTypeGuesser = $mimeTypeGuesser;
    }

    public function save(DesignPhoto $photo, File $file)
    {
        if ($file && $file->getPath()) {
            if (!file_exists($this->upload_directory)) {
                mkdir($this->upload_directory, 0777, true);
            }
            $name = $file->getHash() . ( ($ext = $this->mimeTypeGuesser->guess($file->getMime())) ? '.'.$ext : '');
            copy($file->getPath(), $this->upload_directory.'/'.$name);
        }
        //$this->load($photo, $file);
    }

    protected function getUrl(DesignPhoto $photo, File $file)
    {
        $url = 'http://api.mutabor3s.miksir.dev.artutkin.ru/uploads/designphoto/';
        $name = $file->getHash() . ( ($ext = $this->mimeTypeGuesser->guess($file->getMime())) ? '.'.$ext : '');
        return $url . $name;
    }
}