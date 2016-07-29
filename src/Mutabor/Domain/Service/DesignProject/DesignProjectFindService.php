<?php


namespace Mutabor\Domain\Service\DesignProject;


use Mutabor\Domain\Model\DesignProject\DesignProject;
use Mutabor\Domain\Model\DesignProject\DesignProjectDoesNotExistException;
use Mutabor\Domain\Model\DesignProject\DesignProjectId;
use Mutabor\Domain\Model\DesignProject\DesignProjectRepository;
use Mutabor\Domain\Model\User\UserId;
use Mutabor\Domain\Validation\AddError;
use Mutabor\Domain\Validation\FieldError;
use Mutabor\Domain\Validation\ValidationSandbox;

class DesignProjectFindService
{
    /**
     * @var DesignProjectRepository
     */
    private $repository;
    /**
     * @var ValidationSandbox
     */
    private $validationSandbox;

    public function __construct(
        DesignProjectRepository $designProjectRepository,
        ValidationSandbox $validationSandbox
    )
    {
        $this->repository = $designProjectRepository;
        $this->validationSandbox = $validationSandbox;
    }

    /**
     * @param string $id
     * @return DesignProject
     * @throws DesignProjectFindException
     * @throws DesignProjectDoesNotExistException
     */
    public function findById(string $id) : DesignProject
    {
        $projectId = $this->validationSandbox->run($this, function () use ($id) {
            return new DesignProjectId($id);
        });

        $this->validationSandbox->checkpoint(new DesignProjectFindException());

        return $this->repository->byId($projectId);
    }

    /**
     * @param string $userid
     * @return array
     * @throws DesignProjectFindException
     */
    public function findByUserId(string $userid) : array
    {
        $projectId = $this->validationSandbox->run($this, function () use ($userid) {
            return new UserId($userid);
        });

        $this->validationSandbox->checkpoint(new DesignProjectFindException());

        return $this->repository->byOwner($projectId);
    }
    
    /**
     * @return DesignProject[]
     */
    public function findAll() : array
    {
        return $this->repository->all();
    }
}