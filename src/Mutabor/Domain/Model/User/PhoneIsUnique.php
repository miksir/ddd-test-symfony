<?php


namespace Mutabor\Domain\Model\User;


class PhoneIsUnique implements PhoneSpecification
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function isSatisfiedBy(Phone $phone)
    {
        try {
            $this->repository->byPhone($phone);
        } catch (UserDoesNotExistException $e) {
            return true;
        }

        return false;
    }
}