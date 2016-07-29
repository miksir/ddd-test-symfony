<?php


namespace Masterdom\Domain\Service\User;


interface UserUpdateRequest extends UserRequest
{
    /**
     * @return string
     */
    public function getOldPassword() : string;
}