<?php


namespace Mutabor\Persistence\Doctrine;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

abstract class DoctrineEntityRepository extends EntityRepository
{
    public function __construct(EntityManager $em)
    {
        $entity = $this->relatedEntity();
        $class = new Mapping\ClassMetadata($entity);

        parent::__construct($em, $class);
    }

    abstract public function relatedEntity() : string;
}