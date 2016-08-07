<?php
/**
 * ページモデルのテスト
 *
 * baserCMS :  Based Website Development Project <http://basercms.net>
 * Copyright 2008 - 2015, baserCMS Users Community <http://basercms.net/community/>
 *
 * @copyright		Copyright 2008 - 2015, baserCMS Users Community
 * @link			http://basercms.net baserCMS Project
 * @since			baserCMS v 3.0.6
 * @license			http://basercms.net/license/index.html
 */
App::uses('Page', 'Model');

/**
 * PageTest class
 * 
 * @package Baser.Test.Case.Model
 * @property Page $Page
 */
class PageTest extends BaserTestCase {

	public $fixtures = array(
		'baser.Default.BlogContent',
		'baser.Default.BlogCategory',
		'baser.Default.BlogPost',
		'baser.Default.BlogPostsBlogTag',
		'baser.Default.BlogTag',
		'baser.Default.SearchIndex',
		'baser.Default.SiteConfig',
		'baser.Model.Page.PagePageModel',
		'baser.Default.Permission',
		'baser.Default.Plugin',
		'baser.Default.PluginContent',
		'baser.Default.User',
		'baser.Default.Site',
		'baser.Default.Content',
	);

/**
 * Page
 * 
 * @var Page
 */
	public $Page = null;

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Page = ClassRegistry::init('Page');
	}

/**
 * tearDown
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Page);
		parent::tearDown();
	}

	public function test既存ページチェック正常() {
		$this->Page->create(array(
			'Page' => array(
				'name' => 'test',
				'page_category_id' => '1',
			)
		));
		$this->assertTrue($this->Page->validates());
	}

	public function testPHP構文チェック正常系() {
		$this->Page->create(array(
			'Page' => array(
				'name' => 'test',
				'contents' => '<?php echo "正しい"; ?>',
			)
		));
		$this->assertTrue($this->Page->validates());
	}

	public function testPHP構文チェック異常系() {
		$this->markTestIncomplete('このテストは、まだ実装されていません。');
		$this->Page->create(array(
			'Page' => array(
				'name' => 'test',
				'contents' => '<?php ??>',
			)
		));
		$this->assertFalse($this->Page->validates());
		$this->assertArrayHasKey('contents', $this->Page->validationErrors);
		$this->assertEquals("PHPの構文エラーです： \nPHP Parse error:  syntax error, unexpected '?' in - on line 1 \nErrors parsing -", current($this->Page->validationErrors['contents']));
	}


/**
 * フォームの初期値を設定する
 * 
 * @return	array	初期値データ
 */
	public function testGetDefaultValue() {
		$expected = [];
		$result = $this->Page->getDefaultValue();
		$this->assertEquals($expected, $result, 'フォームの初期値を設定するデータが正しくありません');
	
		//$_SESSION['Auth']が存在する場合
		$_SESSION['Auth'][Configure::read('BcAuthPrefix.admin.sessionKey')] = array(
			'id' => 2,
		);
		$expected = array('Page' => array(
				'author_id' => 2,
			)
		);
		$result = $this->Page->getDefaultValue();
		$this->assertEquals($expected, $result, 'フォームの初期値を設定するデータが正しくありません');
	}

/**
 * beforeSave
 *
 * @param array $options
 * @return boolean
 */
	public function testBeforeSave() {
		$this->markTestIncomplete('このテストは、まだ実装されていません。');
	}

/**
 * 最終登録IDを取得する
 */
	public function testGetInsertID() {
		$this->Page->save(array(
			'Page' => array(
				'name' => 'hoge',
				'title' => 'hoge',
				'url' => '/hoge',
				'description' => 'hoge',
				'status' => 1,
				'page_category_id' => null,
			)
		));
		$result = $this->Page->getInsertID();
		$this->assertEquals(16, $result, '正しく最終登録IDを取得できません');
	}

/**
 * ページテンプレートファイルが開けるかチェックする
 * 
 * @param array $name ページ名
 * @param array $parentId 親コンテンツID
 * @param array $expected 期待値
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider checkOpenPageFileDataProvider
 */
	public function testCheckOpenPageFile($name, $parentId, $expected, $message = null) {
		$data = [
			'Content' => [
				'name' => $name,
				'parent_id' => $parentId,
				'site_id' => 0
			]
		];
		$result = $this->Page->checkOpenPageFile($data);
		$this->assertEquals($expected, $result, $message);
	}

	public function checkOpenPageFileDataProvider() {
		return array(
			array('index', null, true, 'ページテンプレートファイルが開けるか正しくチェックできません'),
			array('company', null, true, 'ページテンプレートファイルが開けるか正しくチェックできません'),
			array('index', 1, true, 'ページテンプレートファイルが開けるか正しくチェックできません'),
			array('index', 2, true, 'ページテンプレートファイルが開けるか正しくチェックできません'),
			array('hoge', null, true, 'ページテンプレートファイルが開けるか正しくチェックできません'),
			array(null, 99, true, 'ページテンプレートファイルが開けるか正しくチェックできません'),
			array('index', 99, true, 'ページテンプレートファイルが開けるか正しくチェックできません'),
			array('hoge', 99, true, 'ページテンプレートファイルが開けるか正しくチェックできません'),
		);
	}

/**
 * afterSave
 * 
 * @param boolean $created
 * @param array $options
 * @return boolean
 */
	public function testAfterSave() {
		$this->markTestIncomplete('このテストは、まだ実装されていません。');

	}

/**
 * 関連ページに反映する
 * 
 * @param string $type
 * @param array $data
 * @return boolean
 */
	public function testRefrect() {
		$this->markTestIncomplete('このテストは、まだ実装されていません。');
	}


/**
 * 検索用データを生成する
 *
 * @param int $name ページID
 * @param string $name ページ名
 * @param id $categoryId ページカテゴリーID
 * @param string $title ページタイトル
 * @param string $url ページURL
 * @param string $description ページ概要
 * @param date $publish_begin 公開開始日時
 * @param date $publish_end 公開終了日時
 * @param date $detail 期待するページdescription
 * @param int $status 公開状態
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider createContentDataProvider
 */
	public function testCreateSearchIndex($id, $name, $categoryId, $title, $url, $description, $publish_begin, $publish_end, $status, $message = null) {
		$this->markTestIncomplete('このテストは、まだ実装されていません。');
		
		$data = array(
			'Page' => array(
				'id' => $id,
				'name' => $name,
				'page_category_id' => $categoryId,
				'title' => $title,
				'url' => $url,
				'description' => $description,
				'publish_begin' => $publish_begin,
				'publish_end' => $publish_end,
				'status' => $status,
			)
		);

		$expected = array('Content' => array(
				'model_id' => $id,
				'type' => 'ページ',
				'category' => '',
				'title' => $title,
				'detail' => '',
				'url' => $url,
				'status' => $status,
			)
		);
		$result = $this->Page->createContent($data);
		$this->assertEquals($expected, $result, $message);
	}


	public function createContentDataProvider() {
		return array(
			array(1, 'index', null, 'index', '/index', '', null, null, true, '検索用データを正しく生成できません'),
			array(1, 'index', null, 'タイトル', '/index', '', null, null, true, '検索用データを正しく生成できません'),
		);
	}


/**
 * beforeDelete
 *
 * @param $cascade
 * @param array $expected 期待値
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider beforeDeleteDataProvider
 */
	public function testBeforeDelete($id, $message = null) {
		// 削除したファイルを再生するため内容を取得
		$page = $this->Page->find('first', [
			'conditions' => ['Page.id' => $id],
			'recursive' => 0,
			]
		);
		$path = APP . 'View' . DS . 'Pages' . $page['Content']['url'] . '.php';
		$File = new File($path);  
		$content = $File->read();

		// 削除実行
		$this->Page->delete($id);

		// 元のファイルを再生成
		$File->write($content);
		$File->close();

		// Contentも削除されているかチェック
		$this->Content = ClassRegistry::init('Content');
		$exists = $this->Content->exists($page['Content']['id']);
		$this->assertFalse($exists, $message);
		unset($this->Content);

	}

	public function beforeDeleteDataProvider() {
		return array(
			array(2, 'PageモデルのbeforeDeleteが機能していません'),
		);
	}

/**
 * DBデータを元にページテンプレートを全て生成する
 */
	public function testCreateAllPageTemplate() {
		$this->Page->createAllPageTemplate();

		// ファイルが生成されているか確認
		$result = true;
		$pages = $this->Page->find('all', ['conditions' => ['Content.status' => true], 'recursive' => 0]);
		foreach ($pages as $page) {
			$path = $this->Page->getPageFilePath($page);
			if (!file_exists($path)) {
				$result = false;
			}
			// フィクスチャ：Default.PageのPage情報にあわせて独自に追加したファイルを削除
			if ($page['Page']['id'] > 12) {
				@unlink($path);
			}
		}
		$this->assertEquals(true, $result, 'DBデータを元にページテンプレートを全て生成できません');
	}


/**
 * ページテンプレートを生成する
 * 
 * @param array $name ページ名
 * @param array $categoryId ページカテゴリーID
 * @param array $expected 期待値
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider createPageTemplateDataProvider
 */
	public function testCreatePageTemplate($name, $categoryId, $expected, $message = null) {

		$data = array(
			'Page' => array(
				'contents' => '',
			),
			'Content' => array(
				'name' => $name,
				'parent_id' => $categoryId,
				'site_id' => 0,
				'title' => ''
			)
		);
		$path = $this->Page->getPageFilePath($data);

		// ファイル生成
		$this->Page->createPageTemplate($data);

		// trueなら生成されている
		$result = file_exists($path);
		
		// 生成されているファイル削除
		@unlink($path);

		$this->assertEquals($expected, $result, $message);
	}

	public function createPageTemplateDataProvider() {
		return array(
			array('hoge.php', null, true, 'ページテンプレートを生成できません'),
			array('hoge.php', 1, true, 'ページテンプレートを生成できません'),
			array('hoge.php', 2, true, 'ページテンプレートを生成できません'),
		);
	}

/**
 * ページファイルを削除する
 * 
 * @param array $name ページ名
 * @param array $categoryId ページカテゴリーID
 * @param array $expected 期待値
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider delFileDataProvider
 */
	public function testDelFile($name, $categoryId, $expected, $message = null) {

		$data = array(
			'Page' => array(
				'contents' => '',
			),
			'Content' => array(
				'name' => $name,
				'parent_id' => $categoryId,
				'site_id' => 0,
				'title' => ''
			)
		);

		$path = $this->Page->getPageFilePath($data);

		$File = new File($path);

		// 存在するファイルパスか
		if ($File->exists()) {

			// 削除したファイルを再生成するため内容取得
			$tmp_content = $File->read();

			// ファイル削除
			$this->Page->delFile($data);

			// trueなら削除済み
			$result = !file_exists($path);
			
			// 削除したファイルを再生成	
			$File->write($tmp_content);

		} else {
			$result = $this->Page->delFile($data);

		}

		$File->close();
		
		$this->assertEquals($expected, $result, $message);
	}

	public function delFileDataProvider() {
		return array(
			array('index', null, true, 'ページファイルを削除できません'),
			array('index', 1, true, 'ページファイルを削除できません'),
			array('index', 2, true, 'ページファイルを削除できません'),
		);
	}

/**
 * 本文にbaserが管理するタグを追加する
 * 
 * @param string $id ID
 * @param string $contents 本文
 * @param string $title タイトル
 * @param string $description 説明文
 * @param string $code コード
 * @param array $expected 期待値
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider addBaserPageTagDataProvider
 */
	public function testAddBaserPageTag($id, $contents, $title, $description, $code, $expected, $message = null) {
		$result = $this->Page->addBaserPageTag($id, $contents, $title, $description, $code);
		$this->assertRegExp('/' . $expected . '/s', $result, $message);
	}

	public function addBaserPageTagDataProvider() {
		return array(
			array(1, 'contentdayo', 'titledayo', 'descriptiondayo', 'codedayo',
						"<!-- BaserPageTagBegin -->.*setTitle\('titledayo'\).*setDescription\('descriptiondayo'\).*setPageEditLink\(1\).*codedayo.*contentdayo",
						'本文にbaserが管理するタグを追加できません'),
		);
	}

/**
 * コントロールソースを取得する
 * 
 * MEMO: $optionのテストについては、UserTest, PageCategoryTestでテスト済み
 * 
 * @param string $field フィールド名
 * @param array $options
 * @param array $expected 期待値
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider getControlSourceDataProvider
 */
	public function testGetControlSource($field, $expected, $message = null) {
		$result = $this->Page->getControlSource($field);
		$this->assertEquals($expected, $result, $message);
	}

	public function getControlSourceDataProvider() {
		return array(
			array('author_id', array(1 => 'basertest', 2 => 'basertest2'), 'コントロールソースを取得できません'),
		);
	}

/**
 * キャッシュ時間を取得する
 * 
 * @param string $url
 * @param array $expected 期待値
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider getCacheTimeDataProvider
 */
	public function testGetCacheTime($url, $expected, $message = null) {
		$result = $this->Page->getCacheTime($url);
		$this->assertEquals($expected, $result, $message);
	}

	public function getCacheTimeDataProvider() {
		return array(
			array('/index', '+5 min', 'キャッシュ時間を取得できません'),
		);
	}

/**
 * ページファイルを登録する
 * ※ 再帰処理
 *
 * @param string $targetPath
 * @param string $parentCategoryId
 * @return array 処理結果 all / success
 */
	public function testEntryPageFiles() {
		$this->markTestIncomplete('このテストは、まだ実装されていません。');
	}

/**
 * 固定ページとして管理されているURLかチェックする
 * 
 * @param string $url URL
 * @param bool $expects true Or false
 * @return void
 * @dataProvider isPageUrlDataProvider
 */
	public function testIsPageUrl($url, $expects) {
		$result = $this->Page->isPageUrl($url);
		$this->assertEquals($result, $expects);
	}

	public function isPageUrlDataProvider() {
		return array(
			array('/service', true),
			array('/service.html', true),
			array('/servce.css', false),
			array('/', true),
			array('/hoge', false)
		);
	}


/**
 * delete
 *
 * @param mixed $id ID of record to delete
 * @param array $expected 期待値
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider deleteDataProvider
 */
	public function testDelete($id, $expected, $message = null) {

		// 削除したファイルを再生するため内容を取得
		$Page = $this->Page->find('first', [
			'conditions' => ['Page.id' => $id],
			'fields' => ['Content.url'],
			'recursive' => 0
			]
		);
		$path = APP . 'View' . DS . 'Pages' . $Page['Content']['url'] . '.php';
		$File = new File($path);  
		$Content = $File->read();

		// 削除実行
		$this->Page->delete($id);
		$this->assertFileNotExists($path, $message);

		// 元のファイルを再生成
		$File->write($Content);
		$File->close();

		// 削除できているか確認用にデータ取得
		$result = $this->Page->exists($id);
		$this->assertEquals($expected, $result, $message);
	}

	public function deleteDataProvider() {
		return array(
			array(1, false, 'ページデータを削除できません'),
		);
	}

/**
 * ページデータをコピーする
 * 
 * @param int $id ページID
 * @param int $newParentId 新しい親コンテンツID
 * @param string $newTitle 新しいタイトル
 * @param int $newAuthorId 新しい作成者ID
 * @param int $newSiteId 新しいサイトID
 * @param string $message テストが失敗した時に表示されるメッセージ
 * @dataProvider copyDataProvider
 */
	public function testCopy($id, $newParentId, $newTitle, $newAuthorId, $newSiteId, $message = null) {
		$result = $this->Page->copy($id, $newParentId, $newTitle, $newAuthorId, $newSiteId);

		// コピーしたファイル存在チェック
		$path = APP . 'View' . DS . 'Pages' . $result['Content']['url'] . '.php';
		$this->assertFileExists($path, $message);
		@unlink($path);

		// DBに書き込まれているかチェック
		$exists = $this->Page->exists($result['Page']['id']);
		$this->assertTrue($exists);
	}

	public function copyDataProvider() {
		return array(
			array(1, 1, 'hoge1', 1, 0, 'ページデータをコピーできません'),
			array(3, 1, 'hoge', 1, 0, 'ページデータをコピーできません')
		);
	}

/**
 * PHP構文チェック
 * 成功時
 *
 * @param string $code PHPのコード
 * @return void
 * @dataProvider phpValidSyntaxDataProvider
 */
	public function testPhpValidSyntax($code) {
		$this->assertTrue($this->Page->phpValidSyntax(array('contents' => $code)));
	}

	public function phpValidSyntaxDataProvider() {
		return array(
			array('<?php $this->BcBaser->setTitle(\'test\');'),
		);
	}

/**
 * PHP構文チェック
 * 失敗時
 *
 * @param string $line エラーが起こる行
 * @param string $code PHPコード
 * @return void
 * @dataProvider phpValidSyntaxWithInvalidDataProvider
 */
	public function testPhpValidSyntaxWithInvalid($line, $code) {
		$this->assertContains("on line {$line}", $this->Page->phpValidSyntax(array('contents' => $code)));
	}

	public function phpValidSyntaxWithInvalidDataProvider() {
		return array(
			array(1, '<?php echo \'test'),
			array(2, '<?php echo \'test\';' . PHP_EOL . 'echo \'hoge')
		);
	}

}
