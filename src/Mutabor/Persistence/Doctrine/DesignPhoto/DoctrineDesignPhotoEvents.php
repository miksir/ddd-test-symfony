<?php


namespace Mutabor\Persistence\Doctrine\DesignPhoto;


use Doctrine\ORM\Event\LifecycleEventArgs;
use Mutabor\Domain\Model\DesignPhoto\DesignPhoto;

class DoctrineDesignPhotoEvents
{
    /**
     * @var DoctrineDesignPhotoFileStorage
     */
    private $photoFileStorage;

    public function __construct(
        DoctrineDesignPhotoFileStorage $photoFileStorage
    )
    {
        $this->photoFileStorage = $photoFileStorage;
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof DesignPhoto) {
            return;
        }

        $this->photoFileStorage->load($entity, $entity->getFile());
    }
}