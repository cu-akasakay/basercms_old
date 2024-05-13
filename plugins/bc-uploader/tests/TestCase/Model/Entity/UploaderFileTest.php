<?php

namespace BcUploader\Test\TestCase\Model\Entity;

use BaserCore\TestSuite\BcTestCase;
use BcUploader\Model\Entity\UploaderFile;
use CakephpFixtureFactories\Scenario\ScenarioAwareTrait;

class UploaderFileTest extends BcTestCase
{
    /**
     * Trait
     */
    use ScenarioAwareTrait;

    /**
     * @var UploaderFile
     */
    public $UploaderFile;
    public function setUp(): void
    {
        parent::setUp();
        $this->UploaderFile = $this->getTableLocator()->get('BcUploader.UploaderFiles');
    }

    public function tearDown(): void
    {
        unset($this->UploaderFile);
        parent::tearDown();
    }

    public function test_filesExists()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    public function test_getSmall()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    public function test_getMedium()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    public function test_getLarge()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    public function test_getFileNameBySize()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    public function test_fileExists()
    {
        $this->markTestIncomplete('このテストは、まだ実装されていません。');
    }

    /**
     * test isLimited
     */
    public function test_isLimited()
    {
        //isLimited true
        $uploaderFile = new UploaderFile([
            'publish_begin' => '2021-01-01 00:00:00',
            'publish_end' => '2021-12-31 23:59:59',
        ]);
        $this->assertTrue($uploaderFile->isLimited());

        //isLimited false
        $uploaderFile = new UploaderFile([
            'publish_begin' => null,
            'publish_end' => null,
        ]);
        $this->assertFalse($uploaderFile->isLimited());
    }

}