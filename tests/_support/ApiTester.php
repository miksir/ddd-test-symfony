<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

   /**
    * Define custom actions here
    */


    public function registerTestUser($params = [])
    {
        $I = $this;
        
        $I->sendPOST('/users.json', array_merge([
            'firstname' => 'Dave',
            'lastname' => 'Volland',
            'email' => 'test@test.ru',
            'phone' => '8 (926) 123-12-34',
            'password' => 'veryStr0nG!',
        ], $params));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $userId = $I->grabDataFromResponseByJsonPath('$.user.id');
        $userToken = $I->grabDataFromResponseByJsonPath('$.token');
        
        return [$userId[0], $userToken[0]];
    }

    public function amFetchingUrlUsingCurl($url, $options = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if ($options) {
            curl_setopt_array($curl, $options);
        }
        $pic = curl_exec($curl);
        $info = curl_getinfo($curl);
        $info['body'] = $pic;
        curl_close($curl);

        return $info;
    }
}
