<?php


namespace Mutabor\Domain\Service\User;


interface UserRequest
{
    /**
     * @return string
     */
    public function getFirstname() : string;

    /**
     * @return string
     */
    public function getLastname() : string;

    /**
     * @return string
     */
    public function getEmail() : string;

    /**
     * @return string
     */
    public function getPhone() : string;

    /**
     * @return string
     */
    public function getPassword() : string;
}