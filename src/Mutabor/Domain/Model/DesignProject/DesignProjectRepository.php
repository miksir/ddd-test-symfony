<?php


namespace Mutabor\Domain\Model\DesignProject;


use Mutabor\Domain\Model\User\UserId;
use Mutabor\Domain\VO\SiteName;

interface DesignProjectRepository
{
    /**
     * @param DesignProjectId $projectId
     * @return DesignProject
     * @throws DesignProjectDoesNotExistException
     */
    public function byId(DesignProjectId $projectId) : DesignProject;

    /**
     * @return DesignProject[]
     */
    public function all() : array;

    /**
     * @param SiteName $siteName
     * @return DesignProject
     * @throws DesignProjectDoesNotExistException
     */
    public function bySiteName(SiteName $siteName) : DesignProject;

    /**
     * @param UserId $userId
     * @return DesignProject[]
     */
    public function byOwner(UserId $userId) : array;

    public function add(DesignProject $project);

    public function remove(DesignProject $project);

    public function nextIdentity() : DesignProjectId;
    
    public function nextInteriorIdentity() : DesignInteriorId;
}