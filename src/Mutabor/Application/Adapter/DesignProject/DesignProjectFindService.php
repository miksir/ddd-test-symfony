<?php


namespace Mutabor\Application\Adapter\DesignProject;


use Mutabor\Domain\Model\DesignProject\DesignProjectDoesNotExistException;
use Mutabor\Domain\Service\DesignProject\DesignProjectFindException;

class DesignProjectFindService
{
    /**
     * @var \Mutabor\Domain\Service\DesignProject\DesignProjectFindService
     */
    private $findService;

    public function __construct(\Mutabor\Domain\Service\DesignProject\DesignProjectFindService $findService)
    {
        $this->findService = $findService;
    }

    /**
     * @param string $id
     * @return DesignProject
     * @throws DesignProjectFindException
     * @throws DesignProjectDoesNotExistException
     */
    public function findById(string $id)
    {
        $project = $this->findService->findById($id);
        return DesignProject::createFromDomain($project);
    }

    public function findByUserId(string $userId)
    {
        $projects = $this->findService->findByUserId($userId);
        $decorated_projects = [];
        foreach ($projects as $project) {
            $decorated_projects[] = DesignProject::createFromDomain($project);
        }
        return $decorated_projects;
    }

}