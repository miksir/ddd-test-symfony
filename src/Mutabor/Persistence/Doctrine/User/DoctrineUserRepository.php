<?php


namespace Mutabor\Persistence\Doctrine\User;

use Mutabor\Domain\Model\User\Email;
use Mutabor\Domain\Model\User\Phone;
use Mutabor\Domain\Model\User\User;
use Mutabor\Domain\Model\User\UserDoesNotExistException;
use Mutabor\Domain\Model\User\UserId;
use Mutabor\Domain\Model\User\UserRepository;
use Mutabor\Persistence\Doctrine\DoctrineEntityRepository;
use Ramsey\Uuid\Uuid;

class DoctrineUserRepository extends DoctrineEntityRepository implements UserRepository
{
    public function relatedEntity() : string 
    {
        return User::class;
    }

    /**
     * @param UserId $userId
     * @return User
     * @throws UserDoesNotExistException
     */
    public function byId(UserId $userId) : User
    {
        $user = $this->find($userId);
        if (is_null($user)) {
            throw new UserDoesNotExistException();
        }
        return $user;
    }

    /**
     * @return User[]
     */
    public function all() : array
    {
        return $this->findAll();
    }

    /**
     * @param Email $email
     * @return User
     * @throws UserDoesNotExistException
     */
    public function byEmail(Email $email) : User
    {
        $user = $this->findOneBy(['email' => (string)$email]);
        if (is_null($user)) {
            throw new UserDoesNotExistException();
        }
        return $user;
    }

    /**
     * @param Phone $phone
     * @return User
     * @throws UserDoesNotExistException
     */
    public function byPhone(Phone $phone) : User
    {
        $user = $this->findOneBy(['phone' => (string)$phone]);
        if (is_null($user)) {
            throw new UserDoesNotExistException();
        }
        return $user;
    }

    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush($user);
    }

    /**
     * @param User $user
     */
    public function remove(User $user)
    {
        $this->getEntityManager()->remove($user);
    }

    /**
     * @return UserId
     */
    public function nextIdentity() : UserId
    {
        return new UserId(Uuid::uuid4()->toString());
    }
}