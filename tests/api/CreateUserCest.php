<?php


class CreateUserCest
{

    public function registerUser(ApiTester $I)
    {
        $I->wantTo('register new user via REST API');

        $I->sendPOST('/users.json', [
            'firstname' => 'Dave',
            'lastname' => 'Volland',
            'email' => 'test@test.ru',
            'phone' => '8 (926) 123-12-34',
            'password' => 'veryStr0nG!',
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->expectTo("see user structure and do not see password");
        $I->seeResponseContainsJson(['user' => [
            'firstname' => 'Dave',
            'lastname' => 'Volland',
            'email' => 'test@test.ru',
            'phone' => '79261231234',
        ]]);
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.password");

        // Assigned ID, uuid4
        $I->seeResponseMatchesJsonType(['id' => 'string:regex(~^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$~i)'], '$.user');
        $userId = $I->grabDataFromResponseByJsonPath('$.user.id');

        // Authentication token
        $I->amGoingTo("get authentication token");
        $I->seeResponseMatchesJsonType(['token' => 'string:regex(~^\Q'.$userId[0].'\E:\w{128}:\w{8}$~)']);
        $userToken = $I->grabDataFromResponseByJsonPath('$.token');
        $userToken = $userToken[0];

        // check identity
        $I->amGoingTo("authenticate with token");
        $I->haveHttpHeader('X-Auth-Token', $userToken);
        $I->sendGET('/identity.json');
        $I->expectTo("see user information and do not see user password");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['user' => [
            'firstname' => 'Dave',
            'lastname' => 'Volland',
            'email' => 'test@test.ru',
            'phone' => '79261231234',
        ]]);
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.password");
    }


    public function inputValidation(ApiTester $I)
    {
        $I->wantTo("check input data validation");

        $I->amGoingTo("use invalid email");
        $I->sendPOST('/users.json', [
            'firstname' => 'Dave',
            'lastname' => 'Volland',
            'email' => 'test@test',
            'phone' => '8 (926) 123-12-34',
            'password' => 'veryStr0nG!',
        ]);
        $I->seeResponseCodeIs(400);

        $I->amGoingTo("use invalid phone");
        $I->sendPOST('/users.json', [
            'firstname' => 'Dave',
            'lastname' => 'Volland',
            'email' => 'test@test.ru',
            'phone' => '12345',
            'password' => 'veryStr0nG!',
        ]);
        $I->seeResponseCodeIs(400);
        $I->sendPOST('/users.json', [
            'firstname' => 'Dave',
            'lastname' => 'Volland',
            'email' => 'test@test.ru',
            'phone' => '9 (111) 111-11-11',
            'password' => 'veryStr0nG!',
        ]);
        $I->seeResponseCodeIs(400);

        $I->amGoingTo("use correct phone formats");
        $I->registerTestUser(['email' => 'test1@test.ru', 'phone' => '71234567890']);
        $I->registerTestUser(['email' => 'test2@test.ru', 'phone' => '+71234567891']);
        $I->registerTestUser(['email' => 'test3@test.ru', 'phone' => '81234567892']);
        $I->registerTestUser(['email' => 'test4@test.ru', 'phone' => '+7 (123) 456-78-93']);
        $I->registerTestUser(['email' => 'test5@test.ru', 'phone' => '8 (123) 456-78-94']);

    }

    public function validateIdentityEmail(ApiTester $I)
    {
        $I->wantTo("authenticate user by email");

        list($userId, $userToken) = $I->registerTestUser(['email' => 'test2@test.ru', 'password' => 'sfwqnrfqnw32d']);

        $I->sendPOST('/identities.json', [
            'login' => 'test2@test.ru',
            'password' => 'sfwqnrfqnw32d'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['user' => ['id' => $userId]]);
        $I->seeResponseMatchesJsonType(['token' => 'string:regex(~^\Q'.$userId.'\E:\w{128}:\w{8}$~)']);
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.password");
    }


    public function validateIdentityPhone(ApiTester $I)
    {
        $I->wantTo("authenticate user by phone");

        list($userId, $userToken) = $I->registerTestUser(['phone' => '+7 (343) 343-55-22', 'password' => 'dft235244']);

        $I->sendPOST('/identities.json', [
            'login' => '8 (343) 343-55-22',
            'password' => 'dft235244'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['user' => ['id' => $userId]]);
        $I->seeResponseMatchesJsonType(['token' => 'string:regex(~^\Q'.$userId.'\E:\w{128}:\w{8}$~)']);
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.password");
    }

    public function getSpecificUser(ApiTester $I)
    {
        $I->wantTo('get public information about user');

        list($userId, $userToken) = $I->registerTestUser(['firstname' => 'Vasisualiy', 'lastname' => 'Utkin']);

        $I->sendGET("/users/{$userId}.json");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['user' => [
            'id' => $userId,
            'firstname' => 'Vasisualiy',
            'lastname' => 'Utkin',
        ]]);
        $I->expect("do not see user email, phone and password");
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.email");
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.phone");
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.password");
    }

    public function updateProfileAnonymous(ApiTester $I)
    {
        $I->wantTo("update user profile without authentication");

        list($userId, $userToken) = $I->registerTestUser();

        // update without authentication
        $I->sendPUT("/users/{$userId}.json", [
            'email' => 'test2@test.ru'
        ]);
        $I->seeResponseCodeIs(401);
    }

    public function updateOtherUserProfile(ApiTester $I)
    {
        $I->wantTo("update other user profile");

        list($userId, $userToken) = $I->registerTestUser();
        list($userId2, $userToken2) = $I->registerTestUser(['email' => 'test2@test.ru', 'phone' => '8 (321) 321-31-21']);

        $I->haveHttpHeader('X-Auth-Token', $userToken2);

        $I->sendPUT("/users/{$userId}.json", [
            'email' => 'test2@test.ru',
            'phone' => '8 (234) 324-33-12',
            'firstname' => 'Vasisualiy',
            'lastname' => 'Utkin',
        ]);
        $I->seeResponseCodeIs(403);
    }

    public function updateOwnProfile(ApiTester $I)
    {
        $I->wantTo("update own profile");

        list($userId, $userToken) = $I->registerTestUser(['password' => '23wr2f23rt42']);

        $I->haveHttpHeader('X-Auth-Token', $userToken);

        $I->sendPUT("/users/{$userId}.json", [
            'email' => 'test2@test.ru',
            'phone' => '8 (234) 324-33-12',
            'firstname' => 'Vasisualiy',
            'lastname' => 'Utkin',
        ]);
        $I->seeResponseCodeIs(200);

        $I->sendGET('/identity.json');
        $I->expectTo("see user's new information and do not see password");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['user' => [
            'email' => 'test2@test.ru',
            'phone' => '72343243312',
            'firstname' => 'Vasisualiy',
            'lastname' => 'Utkin',
        ]]);
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.password");
    }

    public function passwordChange(ApiTester $I)
    {
        $I->wantTo("change password");

        list($userId, $userToken) = $I->registerTestUser(['password' => '23wr2f23rt42']);

        $I->haveHttpHeader('X-Auth-Token', $userToken);

        // check password change without old password
        $I->amGoingTo("verify that we can't set new password without old password");
        $I->sendPUT("/users/{$userId}.json", [
            'email' => 'test2@test.ru',
            'phone' => '8 (234) 324-33-12',
            'firstname' => 'Vasisualiy',
            'lastname' => 'Utkin',
            'password' => 'sda32qtwre4t342t'
        ]);
        $I->seeResponseCodeIs(400);

        // password change with old password
        $I->amGoingTo("change password");
        $I->sendPUT("/users/{$userId}.json", [
            'email' => 'test2@test.ru',
            'phone' => '8 (234) 324-33-12',
            'firstname' => 'Vasisualiy',
            'lastname' => 'Utkin',
            'password' => 'sda32qtwre4t342t',
            'old_password' => '23wr2f23rt42'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.password");

        // lest check, that old token no valid more
        $I->sendGET('/identity.json');
        $I->expectTo("see authentication fail because password changed, so token no valid more");
        $I->seeResponseCodeIs(401);

        // lets check that password changed
        $I->amGoingTo("authenticate using new password");
        $I->deleteHeader('X-Auth-Token');
        $I->sendPOST('/identities.json', [
            'login' => '72343243312',
            'password' => 'sda32qtwre4t342t'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->expectTo("see user ID, new authentication token and do not see user password");
        $I->seeResponseContainsJson(['user' => ['id' => $userId]]);
        $I->seeResponseMatchesJsonType(['token' => 'string:regex(~^\Q'.$userId.'\E:\w{128}:\w{8}$~)']);
        $I->dontSeeResponseJsonMatchesJsonPath("$.user.password");
    }
}
