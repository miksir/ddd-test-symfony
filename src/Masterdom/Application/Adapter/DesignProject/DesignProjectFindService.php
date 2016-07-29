<?php


namespace Masterdom\Application\Adapter\DesignProject;


use Masterdom\Domain\Model\DesignProject\DesignProjectDoesNotExistException;
use Masterdom\Domain\Service\DesignProject\DesignProjectFindException;

class DesignProjectFindService
{
    /**
     * @var \Masterdom\Domain\Service\DesignProject\DesignProjectFindService
     */
    private $findService;

    public function __construct(\Masterdom\Domain\Service\DesignProject\DesignProjectFindService $findService)
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