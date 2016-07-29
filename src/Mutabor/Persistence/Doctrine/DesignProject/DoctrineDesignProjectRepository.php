<?php


namespace Mutabor\Persistence\Doctrine\DesignProject;


use Mutabor\Domain\Model\DesignProject\DesignInteriorId;
use Mutabor\Domain\Model\DesignProject\DesignProject;
use Mutabor\Domain\Model\DesignProject\DesignProjectDoesNotExistException;
use Mutabor\Domain\Model\DesignProject\DesignProjectId;
use Mutabor\Domain\Model\DesignProject\DesignProjectRepository;
use Mutabor\Domain\Model\User\UserId;
use Mutabor\Domain\VO\SiteName;
use Mutabor\Persistence\Doctrine\DoctrineEntityRepository;
use Ramsey\Uuid\Uuid;

class DoctrineDesignProjectRepository extends DoctrineEntityRepository implements DesignProjectRepository
{

    /**
     * @param DesignProjectId $projectId
     * @return DesignProject
     * @throws DesignProjectDoesNotExistException
     */
    public function byId(DesignProjectId $projectId) : DesignProject
    {
        $project = $this->find($projectId);
        if (is_null($project)) {
            throw new DesignProjectDoesNotExistException();
        }
        return $project;
    }

    /**
     * @return DesignProject[]
     */
    public function all() : array
    {
        return $this->findAll();
    }

    /**
     * @param SiteName $siteName
     * @return DesignProject
     * @throws DesignProjectDoesNotExistException
     */
    public function bySiteName(SiteName $siteName) : DesignProject
    {
        $project = $this->findOneBy(['site_name' => (string)$siteName]);
        if (is_null($project)) {
            throw new DesignProjectDoesNotExistException();
        }
        return $project;
    }

    public function add(DesignProject $project)
    {
        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();
    }

    public function remove(DesignProject $project)
    {
        $this->getEntityManager()->remove($project);
    }

    public function nextIdentity() : DesignProjectId
    {
        return new DesignProjectId(Uuid::uuid4()->toString());
    }

    public function nextInteriorIdentity() : DesignInteriorId
    {
        return new DesignInteriorId(Uuid::uuid4()->toString());
    }
    
    public function relatedEntity() : string
    {
        return DesignProject::class;
    }

    /**
     * @param UserId $userId
     * @return DesignProject[]
     */
    public function byOwner(UserId $userId) : array
    {
        $q = $this->_em->createQuery('SELECT p FROM Mutabor\Domain\Model\DesignProject\DesignProject p, Mutabor\Domain\Model\User\User u WHERE u.id=:userid');
        $q->setParameter(':userid', (string)$userId);
        return $q->getResult();
    }
}