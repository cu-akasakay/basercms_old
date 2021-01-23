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

$this->BcBaser->i18nScript([
    'message1' => __d('baser', "このデータを本当に無効にしてもいいですか？\nプラグインフォルダ内のファイル、データベースに保存した情報は削除されずそのまま残ります。"),
    'message2' => __d('baser', "本当に削除してもいいですか？\nプラグインフォルダ内のファイル、データベースのデータも全て削除されます。"),
    'message3' => __d('baser', "本当に無効にしてもいいですか？\nプラグインフォルダ内のファイル、データベースに保存した情報は削除されずそのまま残ります。")
]);
$this->BcBaser->js('admin/plugins/index.bundle', false);
$this->BcAdmin->addAdminMainBodyHeaderLinks([
    'url' => ['action' => 'add'],
    'title' => __d('baser', '新規追加'),
]);
?>


<div id="AjaxBatchUrl" style="display:none"><?php $this->BcBaser->url(['controller' => 'plugins', 'action' => 'ajax_batch']) ?></div>
<div id="AjaxSorttableUrl" style="display:none"><?php $this->BcBaser->url(['controller' => 'plugins', 'action' => 'ajax_update_sort']) ?></div>
<div id="AlertMessage" class="message" style="display:none"></div>
<div id="MessageBox" style="display:none">
    <div id="flashMessage" class="notice-message"></div>
</div>

<div id="tabs">
    <ul>
        <li><a href="#DataList"><?php echo __d('baser', '所有プラグイン') ?></a></li>
        <li><a href="#BaserMarket"><?php echo __d('baser', 'baserマーケット') ?></a></li>
    </ul>
    <div id="DataList"
         class="bca-data-list"><?php $this->BcBaser->element('BaserCore.Admin/Plugins/index_list') ?></div>
    <div id="BaserMarket">
        <div style="padding:20px;text-align:center;">
            <?php $this->BcBaser->img('admin/ajax-loader.gif', ['alt' => 'Loading...']) ?>
        </div>
    </div>
</div>
