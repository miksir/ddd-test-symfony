<?php


namespace Mutabor\Domain\Model\User;


interface UserRepository
{
    /**
     * @param UserId $userId
     * @return User
     * @throws UserDoesNotExistException
     */
    public function byId(UserId $userId) : User;

    /**
     * @return User[]
     */
    public function all() : array;

    /**
     * @param Email $email
     * @return User
     * @throws UserDoesNotExistException
     */
    public function byEmail(Email $email) : User;

    /**
     * @param Phone $phone
     * @return User
     * @throws UserDoesNotExistException
     */
    public function byPhone(Phone $phone) : User;

    public function add(User $user);

    public function remove(User $user);
    
    public function nextIdentity() : UserId;
}