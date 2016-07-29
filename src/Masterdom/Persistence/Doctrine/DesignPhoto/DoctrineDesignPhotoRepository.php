<?php


namespace Masterdom\Persistence\Doctrine\DesignPhoto;


use Doctrine\ORM\EntityManager;
use Masterdom\Domain\Model\DesignPhoto\DesignPhoto;
use Masterdom\Domain\Model\DesignPhoto\DesignPhotoDoesNotExistException;
use Masterdom\Domain\Model\DesignPhoto\DesignPhotoId;
use Masterdom\Domain\Model\DesignPhoto\DesignPhotoRepository;
use Masterdom\Domain\Model\DesignProject\DesignInteriorId;
use Masterdom\Domain\VO\Url;
use Masterdom\Persistence\Doctrine\DoctrineEntityRepository;
use Ramsey\Uuid\Uuid;

class DoctrineDesignPhotoRepository extends DoctrineEntityRepository implements DesignPhotoRepository
{
    /**
     * @var string
     */
    private $upload_directory;
    /**
     * @var DoctrineDesignPhotoFileStorage
     */
    private $fileStorage;

    public function __construct(
        EntityManager $em, 
        DoctrineDesignPhotoFileStorage $fileStorage
    )
    {
        parent::__construct($em);
        $this->fileStorage = $fileStorage;
    }

    /**
     * @param DesignPhotoId $photoId
     * @return DesignPhoto
     * @throws DesignPhotoDoesNotExistException
     */
    public function byId(DesignPhotoId $photoId) : DesignPhoto
    {
        /** @var DesignPhoto $photo */
        $photo = $this->find($photoId);
        if (is_null($photo)) {
            throw new DesignPhotoDoesNotExistException();
        }

        return $photo;
    }

    /**
     * @param DesignInteriorId $interiorId
     * @return DesignPhoto[]
     */
    public function byInterior(DesignInteriorId $interiorId) : array
    {
        // TODO: Implement byInterior() method.
    }

    public function add(DesignPhoto $photo)
    {
        // TODO: Move to event?
        $this->fileStorage->save($photo, $photo->getFile());
        $this->getEntityManager()->persist($photo);
        $this->getEntityManager()->flush($photo);
        $this->getEntityManager()->refresh($photo);
    }

    public function remove(DesignPhoto $photo)
    {
        $this->getEntityManager()->remove($photo);
    }

    public function nextIdentity() : DesignPhotoId
    {
        return new DesignPhotoId(Uuid::uuid4()->toString());
    }

    public function relatedEntity() : string
    {
        return DesignPhoto::class;
    }
}