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

use BaserCore\Annotation\UnitTest;
use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\Note;

/**
 * @checked
 * @note(value="Feedプラグインをコアプラグインにするか検討要")
 */
?>

<h2 class="bca-panel-box__title"><?php echo __d('baser', 'baserCMSニュース') ?></h2>
<?php
// TODO: ucmitz FeedController未実装
// $this->BcBaser->js('/feed/ajax/1?admin_theme=true')
?>
<p class="bca-panel-box__message">
  <small><?php echo __d('baser', 'baserCMSについて、不具合の発見・改善要望がありましたら<a href="https://forum.basercms.net" target="_blank">ユーザーズフォーラム</a> よりお知らせください。') ?></small>
</p>
