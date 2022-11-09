<?php
/**
 * baserCMS :  Based Website Development Project <https://basercms.net>
 * Copyright (c) NPO baser foundation <https://baserfoundation.org/>
 *
 * @copyright     Copyright (c) NPO baser foundation
 * @link          https://basercms.net baserCMS Project
 * @since         5.0.0
 * @license       https://basercms.net/license/index.html MIT License
 */

namespace BcBlog\Controller\Admin;

use BaserCore\Utility\BcSiteConfig;
use BcBlog\Service\Admin\BlogCommentsAdminService;
use BcBlog\Service\Admin\BlogCommentsAdminServiceInterface;
use BaserCore\Annotation\NoTodo;
use BaserCore\Annotation\Checked;
use BaserCore\Annotation\UnitTest;
use BcBlog\Service\BlogCommentsService;
use BcBlog\Service\BlogCommentsServiceInterface;
use Cake\Http\Exception\NotFoundException;

/**
 * ブログコメントコントローラー
 */
class BlogCommentsController extends BlogAdminAppController
{

    /**
     * [ADMIN] ブログを一覧表示する
     *
     * @param BlogCommentsAdminService $service
     * @param int $blogContentId
     * @return void
     * @checked
     * @noTodo
     */
    public function index(BlogCommentsAdminServiceInterface $service, int $blogContentId)
    {
        $this->setViewConditions('BlogComment', [
            'group' => $blogContentId,
            'default' => [
                'query' => [
                    'num' => BcSiteConfig::get('admin_list_num'),
                    'sort' => 'BlogComments.created',
                    'direction' => 'DESC'
                ]
        ]]);
        $this->getRequest()->getSession()->delete('BcApp.viewConditions.BlogCommentsIndex.' . $blogContentId . '.query.blog_post_id');
        try {
            $blogComments = $this->paginate($service->getIndex(array_merge(
                $this->getRequest()->getQueryParams(),
                ['blog_content_id' => $blogContentId]
            )));
        } catch (NotFoundException $e) {
            $url = ['action' => 'index', $blogContentId];
            if($this->getRequest()->getQuery('blog_post_id')) {
                $url['?'] = ['blog_post_id' => $this->getRequest()->getQuery('blog_post_id')];
            }
            return $this->redirect($url);
        }
        $this->set($service->getViewVarsForIndex(
            $blogContentId,
            $this->getRequest()->getQuery('blog_post_id'),
            $blogComments
        ));
    }

    /**
     * ブログコメントを削除する
     *
     * ブログ記事IDでフィルタリングがかかっている場合は、削除後にフィルタリングされた画面にリダイレクトする
     *
     * @param BlogCommentsServiceInterface $service
     * @param int $blogContentId
     * @param int $id
     * @return void
     * @checked
     * @noTodo
     */
    public function delete(BlogCommentsServiceInterface $service, int $blogContentId, int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $entity = $service->get($id);
        if ($service->delete($id)) {
            $this->BcMessage->setSuccess(__d('baser', 'ブログコメント No{0} を削除しました。', $entity->no));
        } else {
            $this->BcMessage->setError(__d('baser', 'データベース処理中にエラーが発生しました。'));
        }
        $url = ['action' => 'index', $blogContentId];
        if($this->getRequest()->getQuery('blog_post_id')) {
            $url['?'] = ['blog_post_id' => $this->getRequest()->getQuery('blog_post_id')];
        }
        return $this->redirect($url);
    }

    /**
     * [ADMIN] 無効状態にする
     *
     * @param BlogCommentsServiceInterface $service
     * @param int $blogContentId
     * @param int $id
     * @return void
     * @checked
     * @noTodo
     */
    public function unpublish(BlogCommentsServiceInterface $service, int $blogContentId, int $id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = $service->unpublish($id);
            if ($result) {
                $this->BcMessage->setSuccess(sprintf(__d('baser', 'ブログコメント No.%s を非公開状態にしました。'), $result->no));
            } else {
                $this->BcMessage->setSuccess(__d('baser', 'データベース処理中にエラーが発生しました。'));
            }
        }
        $url = ['action' => 'index', $blogContentId];
        if($this->getRequest()->getQuery('blog_post_id')) {
            $url['?'] = ['blog_post_id' => $this->getRequest()->getQuery('blog_post_id')];
        }
        return $this->redirect($url);
    }

    /**
     * [ADMIN] 有効状態にする
     *
     * @param BlogCommentsService $service
     * @param int $blogContentId
     * @param int $id
     * @return void
     * @checked
     * @noTodo
     */
    public function publish(BlogCommentsServiceInterface $service, int $blogContentId, int $id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $result = $service->publish($id);
            if ($result) {
                $this->BcMessage->setSuccess(sprintf(__d('baser', 'ブログコメント No.%s を公開状態にしました。'), $result->no));
            } else {
                $this->BcMessage->setSuccess(__d('baser', 'データベース処理中にエラーが発生しました。'));
            }
        }
        $url = ['action' => 'index', $blogContentId];
        if($this->getRequest()->getQuery('blog_post_id')) {
            $url['?'] = ['blog_post_id' => $this->getRequest()->getQuery('blog_post_id')];
        }
        return $this->redirect($url);
    }

    /**
     * 認証用のキャプチャ画像を表示する
     *
     * @return void
     */
    public function captcha($token = null)
    {
        $this->BcCaptcha->render($token);
        exit();
    }

    /**
     * コメント送信用にAjax経由でトークンを取得するアクション
     */
    public function get_token()
    {
        $this->_checkReferer();
        $this->autoRender = false;
        return $this->getToken();
    }
}
