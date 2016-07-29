<?php


namespace Mutabor\Domain\Model\User;


class EmailIsUnique implements EmailSpecification
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }


    public function isSatisfiedBy(Email $email)
    {
        try {
            $this->repository->byEmail($email);
        } catch (UserDoesNotExistException $e) {
            return true;
        }

        return false;
    }
}