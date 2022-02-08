<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) baserCMS User Community <https://basercms.net/community/>
 *
 * @copyright     Copyright (c) baserCMS User Community
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       http://basercms.net/license/index.html MIT License
 */

namespace BaserCore\Test\TestCase\Controller\Api;

use BaserCore\TestSuite\BcTestCase;
use Cake\TestSuite\IntegrationTestTrait;
use BaserCore\Service\PageService;

/**
 * BaserCore\Controller\Api\PagesController Test Case
 */
class PagesControllerTest extends BcTestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.BaserCore.Users',
        'plugin.BaserCore.UsersUserGroups',
        'plugin.BaserCore.Pages',
        'plugin.BaserCore.UserGroups',
        'plugin.BaserCore.Contents',
        'plugin.BaserCore.Sites',
        'plugin.BaserCore.SiteConfigs',
    ];

    /**
     * Access Token
     * @var string
     */
    public $accessToken = null;

    /**
     * Refresh Token
     * @var null
     */
    public $refreshToken = null;

    /**
     * set up
     */
    public function setUp(): void
    {
        parent::setUp();
        $token = $this->apiLoginAdmin(1);
        $this->accessToken = $token['access_token'];
        $this->refreshToken = $token['refresh_token'];
        $this->PageService = new PageService();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
        $this->get('/baser/api/baser-core/pages/index.json?token=' . $this->accessToken);
        $this->assertResponseOk();
        $result = json_decode((string)$this->_response->getBody());
        $this->assertEquals("baserCMSサンプル", $result->pages[0]->folder_template);
    }

    /**
     * Test View
     */
    public function testView()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
        $this->get('/baser/api/baser-core/pages/view/1.json?token=' . $this->accessToken);
        $this->assertResponseOk();
        $result = json_decode((string)$this->_response->getBody());
        $this->assertEquals("baserCMSサンプル", $result->pages->folder_template);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->loginAdmin($this->getRequest());
        $this->enableSecurityToken();
        $this->enableCsrfToken();
        $data = [
            'code' => 'テストcreate',
            'content' => [
                "parent_id" => "1",
                "title" => "新しい フォルダー",
                "plugin" => 'BaserCore',
                "type" => "Page",
                "site_id" => "0",
                "alias_id" => "",
                "entity_id" => "",
            ]
        ];
        $this->post('/baser/api/baser-core/pages/add.json?token=' . $this->accessToken, $data);
        $this->assertResponseOk();
        $Pages = $this->getTableLocator()->get('Pages');
        $query = $Pages->find()->where(['code' => $data['code']]);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
        $this->enableSecurityToken();
        $this->enableCsrfToken();
        $this->delete('/baser/api/baser-core/pages/delete/1.json?token=' . $this->accessToken);
        $this->assertResponseSuccess();
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
        $this->enableSecurityToken();
        $this->enableCsrfToken();
        $data = $this->PageService->getIndex(['folder_template' => "testEdit"])->first();
        $data->content->name = "pageTestUpdate";
        $id = $data->id;
        $this->post("/baser/api/baser-core/pages/edit/${id}.json?token=". $this->accessToken, $data->toArray());
        $this->assertResponseSuccess();
        $query = $this->PageService->getIndex(['folder_template' => $data['folder_template']]);
        $this->assertEquals(1, $query->all()->count());
        $this->assertEquals("pageTestUpdate", $query->all()->first()->content->name);
    }
}
