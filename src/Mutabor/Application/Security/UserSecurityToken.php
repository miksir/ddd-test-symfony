<?php


namespace Mutabor\Application\Security;


use Mutabor\Application\Adapter\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class UserSecurityToken
{
    /**
     * @var string
     */
    private $secret_key;
    /**
     * @var int
     */
    private $lifetime;

    /**
     * UserSecurityToken constructor.
     * @param string $secret_key
     * @param int $lifetime
     */
    public function __construct(string $secret_key, int $lifetime = 2592000)
    {
        $this->secret_key = $secret_key;
        $this->lifetime = $lifetime;
    }

    /**
     * @param UserInterface $user
     * @param Request $request
     * @param null $time
     * @return string
     */
    public function createToken(UserInterface $user, Request $request, $time=null)
    {
        $time = $time ?? time();
        $user_id = (string)($user->getUsername());
        $hash_string = $this->createHash($user, $request, $time);
        $token = sprintf("%s:%s:%08s", $user_id, $hash_string, dechex($time));
        return $token;
    }

    private function createHash(UserInterface $user, Request $request, $mix)
    {
        $ip = '';//$request->getClientIp();
        $user_agent = '';//@$_SERVER['HTTP_USER_AGENT'];
        $user_id = (string)($user->getUsername());
        $hash_string = implode(':', [
            $ip,
            $user_agent,
            $user_id,
            $user->getPassword(),
            $this->secret_key,
            $mix
        ]);
        return $this->hash($hash_string);
    }
    
    private function hash($string)
    {
        return hash('sha512', $string);
    }

    /**
     * @param UserInterface $user
     * @param Request $request
     * @param string $token
     * @return bool
     */
    public function validateToken(UserInterface $user, Request $request, string $token)
    {
        $arr = explode(':', $token);
        if (count($arr) !== 3) {
            return false;
        }

        list($id, $hash, $time) = $arr;

        if ($id !== (string)($user->getUsername())) {
            return false;
        }

        $time = (int)hexdec($time);

        if (($time + $this->lifetime) < time()) {
            return false;
        }

        $new_hash = $this->createHash($user, $request, $time);

        return hash_equals($new_hash, $hash);
    }

    /**
     * @param Request $request
     * @param string $token
     * @return string|null
     */
    public function extractUserId(Request $request, string $token)
    {
        $arr = explode(':', $token);
        if (count($arr) !== 3) {
            return null;
        }
        return $arr[0];
    }
}