<?php


namespace Mutabor\Application\DTO;


use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;
use Mutabor\Application\Adapter\User;

/**
 * @ExclusionPolicy("ALL")
 */
class UserResponse
{
    /**
     * @var User
     * @Type("Mutabor\Application\Adapter\User")
     * @Expose
     */
    private $user;
    /**
     * Authentication token. Pass this token with requests in X-Auth-Token header or in Cookies with 'token' name
     * @var string
     * @Type("string")
     * @Groups({"identity"})
     * @Expose
     */
    private $token;


    public function __construct(User $user, string $token=null)
    {
        $this->user = $user;
        $this->token = $token;
    }
}
