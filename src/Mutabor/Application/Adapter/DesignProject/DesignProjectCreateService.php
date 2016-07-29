<?php


namespace Mutabor\Application\Adapter\DesignProject;


use Mutabor\Application\DTO\DesignProject\DesignProjectRequest;
use Mutabor\Domain\Service\DesignProject\DesignProjectCreateException;
use Mutabor\Domain\Service\DesignProject\DesignProjectCreateService as DomainDesignProjectCreateService;

class DesignProjectCreateService
{
    /**
     * @var DomainDesignProjectCreateService
     */
    private $createService;

    public function __construct(
        DomainDesignProjectCreateService $createService
    )
    {
        $this->createService = $createService;
    }

    /**
     * @param string $user_id
     * @param DesignProjectRequest $request
     * @return DesignProject
     * @throws DesignProjectCreateException
     */
    public function create(string $user_id, DesignProjectRequest $request) : DesignProject
    {
        $request->setUserId($user_id);
        $project = $this->createService->create($request);
        return DesignProject::createFromDomain($project);
    }

    public function update(string $user_id, string $project_id, DesignProjectRequest $request) : DesignProject
    {
        $request->setUserId($user_id);
        $project = $this->createService->update($project_id, $request);
        return DesignProject::createFromDomain($project);
    }
}