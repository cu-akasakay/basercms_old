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

namespace BaserCore\Service;


use Cake\Datasource\EntityInterface;
/**
 * Interface ContentFoldersServiceInterface
 * @package BaserCore\Service
 */
interface ContentFoldersServiceInterface
{
    /**
     * コンテンツフォルダー登録
     * @param array $data
     * @return \Cake\Datasource\EntityInterface
     */
    public function create(array $postData);
}
