<?php


use Symfony\Component\HttpFoundation\File\UploadedFile;

class CreateDesignProjectCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function uploadPhoto(ApiTester $I)
    {
        $I->wantTo('upload new photo');

        list($userId, $userToken) = $I->registerTestUser();

        $I->haveHttpHeader('X-Auth-Token', $userToken);

        $file = codecept_data_dir('some_png_image.png');

        $I->amGoingTo("post test file");
        $I->sendPOST("/users/{$userId}/designprojects/photos.json", [], [
            'file' => new UploadedFile($file, 'some_png_image.png')
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'id' => 'string:regex(~^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$~i)',
            'url' => 'string:url',
            'width' => 'integer',
            'height' => 'integer'
        ], '$.designphoto');

        $I->amGoingTo("check if file accessible via url");
        $pic_url = $I->grabDataFromResponseByJsonPath('$.designphoto.url');

        $curl_request_info = $I->amFetchingUrlUsingCurl($pic_url[0]);
        $I->assertEquals(200, $curl_request_info['http_code']);
    }

    private function _uploadPhotos(ApiTester $I, $userId)
    {
        $photos = [];
        $sizes = [];
        for ($n=1; $n<=6; $n++) {
            $file = codecept_data_dir(sprintf('interiors/%02d.jpg', $n));
            $I->sendPOST("/users/{$userId}/designprojects/photos.json", [], [
                'file' => new UploadedFile($file, sprintf('%02d.jpg', $n))
            ]);
            $I->seeResponseCodeIs(200);
            $I->seeResponseIsJson();
            $photos[$n] = $I->grabDataFromResponseByJsonPath('$.designphoto');
            $sizes[$n] = getimagesize($file);
        }
        return [ $photos, $sizes ];
    }

    public function addProject(ApiTester $I)
    {
        $I->wantTo("add and edit project");

        list($userId, $userToken) = $I->registerTestUser(['firstname' => 'Konstantin', 'lastname' => 'Konstantinopolskiy']);
        list($userId2, $userToken2) = $I->registerTestUser(['email' => 'test2@test.ru', 'phone' => '8 (926) 321-21-43']);

        $I->amGoingTo("upload 6 photos");
        $I->haveHttpHeader('X-Auth-Token', $userToken);
        list($photos, $sizes) = $this->_uploadPhotos($I, $userId);

        $project = [
            'name' => 'Test project',
            'description' => 'This is test project',
            'interiors' => [
                [
                    'id' => 'd89ccc78-9d64-4667-8492-2cbf867545b6',
                    'title' => 'Kitchen Interior',
                    'description' => 'This is description of kitchen interior',
                    'room' => '627f06b8-18c7-4f36-a82e-579860310cae', // Кухня
                    'style' => ['0a5b8f13-18fe-4250-b2f0-0437659dea6f'], // Классика
                    'photos' => [
                        [
                            'id' => $photos[1][0]['id'],
                            'width' => (int)$sizes[1][0],
                            'height' => (int)$sizes[1][1],
                            'url' => $photos[1][0]['url'],
                            'products' => []
                        ],
                        [
                            'id' => $photos[2][0]['id'],
                            'width' => (int)$sizes[2][0],
                            'height' => (int)$sizes[2][1],
                            'url' => $photos[2][0]['url'],
                            'products' => []
                        ],
                    ]
                ],
                [
                    'id' => 'c9c5b9e2-fe7c-46c5-86f9-441cc6436b76',
                    'title' => 'Bathroom Interior',
                    'description' => 'This is description of bathroom interior',
                    'room' => '9074d079-0b32-44f4-95dd-b499025b9bc4', // Ванная
                    'style' => ['5449cbdf-e93a-4bc3-bab2-7447e0fe8614'], // Минимализм
                    'photos' => [
                        [
                            'id' => $photos[3][0]['id'],
                            'width' => (int)$sizes[3][0],
                            'height' => (int)$sizes[3][1],
                            'url' => $photos[3][0]['url'],
                            'products' => []
                        ],
                        [
                            'id' => $photos[4][0]['id'],
                            'width' => (int)$sizes[4][0],
                            'height' => (int)$sizes[4][1],
                            'url' => $photos[4][0]['url'],
                            'products' => []
                        ],
                    ]
                ],
            ]
        ];

        $I->amGoingTo("check that we can not create projects anonymously");
        $I->deleteHeader('X-Auth-Token');
        $I->sendPOST("/users/{$userId}/designprojects.json", $project);
        $I->seeResponseCodeIs(401);

        $I->amGoingTo("check that we can not create projects owned by other user");
        $I->haveHttpHeader('X-Auth-Token', $userToken);
        $I->sendPOST("/users/{$userId2}/designprojects.json", $project);
        $I->seeResponseCodeIs(403);

        $I->amGoingTo("create new project with interiors and photos");
        $I->haveHttpHeader('X-Auth-Token', $userToken);
        $I->sendPOST("/users/{$userId}/designprojects.json", $project);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->expectTo("get ID of new project");
        $projectId = $I->grabDataFromResponseByJsonPath('$.designproject.id');
        $I->assertArrayHasKey(0, $projectId);
        $projectId = $projectId[0];

        $I->amGoingTo('anonymously get new project by ID and compare with posted');
        $I->deleteHeader('X-Auth-Token');
        $I->sendGET("/users/{$userId}/designprojects/{$projectId}.json");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->expectTo("see project with my structure and ID and owner information");
        $I->seeResponseContainsJson(['designproject' => array_merge_recursive($project, [
            'id' => $projectId,
            'owner' => [
                'id' => $userId,
                'firstname' => 'Konstantin',
                'lastname' => 'Konstantinopolskiy'
            ]
        ])]);

        $I->amGoingTo("anonymously get list of projects for our user and check that this new project exists");
        $I->deleteHeader('X-Auth-Token');
        $I->sendGET("/users/{$userId}/designprojects.json");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->expectTo("see only one project with my structure and ID and owner information");
        $I->seeResponseContainsJson(['designprojects' => [0 => array_merge_recursive($project, [
            'id' => $projectId,
            'owner' => [
                'id' => $userId,
                'firstname' => 'Konstantin',
                'lastname' => 'Konstantinopolskiy'
            ]
        ])]]);

        // edit project

        $project = [
            'name' => 'Test project 2',
            'description' => 'This is test project',
            'interiors' => [
                [
                    'id' => 'd89ccc78-9d64-4667-8492-2cbf867545b6',
                    'title' => 'Kitchen Interior',
                    'description' => 'This is description of kitchen interior',
                    'room' => '627f06b8-18c7-4f36-a82e-579860310cae', // Кухня
                    'style' => ['0a5b8f13-18fe-4250-b2f0-0437659dea6f'], // Классика
                    'photos' => [
                        [
                            'id' => $photos[1][0]['id'],
                            'width' => (int)$sizes[1][0],
                            'height' => (int)$sizes[1][1],
                            'url' => $photos[1][0]['url'],
                            'products' => []
                        ],
                        [
                            'id' => $photos[2][0]['id'],
                            'width' => (int)$sizes[2][0],
                            'height' => (int)$sizes[2][1],
                            'url' => $photos[2][0]['url'],
                            'products' => []
                        ],
                    ]
                ],
                [
                    'id' => 'c9c5b9e2-fe7c-46c5-86f9-441cc6436b77',
                    'title' => 'Bedroom Interior',
                    'description' => 'This is description of bedroom interior',
                    'room' => '46735892-c66e-4d6e-ae7e-8a9d07491a20', // Спальня
                    'style' => ['3b75bd90-d649-4c20-b389-51436b79dc35'], // Восток
                    'photos' => [
                        [
                            'id' => $photos[5][0]['id'],
                            'width' => (int)$sizes[5][0],
                            'height' => (int)$sizes[5][1],
                            'url' => $photos[5][0]['url'],
                            'products' => []
                        ],
                        [
                            'id' => $photos[6][0]['id'],
                            'width' => (int)$sizes[6][0],
                            'height' => (int)$sizes[6][1],
                            'url' => $photos[6][0]['url'],
                            'products' => []
                        ],
                    ]
                ],
            ]
        ];

        $I->amGoingTo("test that project can not be edited anonymously");
        $I->deleteHeader('X-Auth-Token');
        $I->sendPUT("/users/{$userId}/designprojects/{$projectId}.json", $project);
        $I->seeResponseCodeIs(401);

        $I->amGoingTo("test that project can not be edited by other user");
        $I->haveHttpHeader('X-Auth-Token', $userToken2);
        $I->sendPUT("/users/{$userId}/designprojects/{$projectId}.json", $project);
        $I->seeResponseCodeIs(403);

        $I->amGoingTo("edit project");
        $I->haveHttpHeader('X-Auth-Token', $userToken);
        $I->sendPUT("/users/{$userId}/designprojects/{$projectId}.json", $project);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->amGoingTo('anonymously get same project again');
        $I->deleteHeader('X-Auth-Token');
        $I->sendGET("/users/{$userId}/designprojects/{$projectId}.json");
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->expectTo("see project with my NEW structure");
        $I->seeResponseContainsJson(['designproject' => array_merge_recursive($project, [
            'id' => $projectId,
            'owner' => [
                'id' => $userId,
                'firstname' => 'Konstantin',
                'lastname' => 'Konstantinopolskiy'
            ]
        ])]);
        $I->expectTo("see only 2 interiors in project, not 3");
        $I->dontSeeResponseJsonMatchesJsonPath("$.designproject.interiors[2].id");
    }

}
