<?php

class PostsController extends AppController {
	// public $scaffold;
	// public $helpers = array('Html', 'Form'); // ←これはデフォルトで使えるみたい

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->deny('add', 'edit', 'delete');
		$this->Auth->allow('index', 'view');
	}

	public function index() {

		// パラメータつきでfindする場合
		// $params = array(
		// 	'order' => 'modified desc',
		// 	'limit' => 2
		// );
		// $this->set('posts', $this->Post->find('all', $params));

		$this->set('posts', $this->Post->find('all'));
	}

	public function view($id = null) {
		$this->Post->id = $id;
		$result = $this->Post->read();

		// お気に入りされている数を取得
		$this->loadModel('PostFavorite');
		$favoriteCount = $this->PostFavorite->find('count', [
			'conditions' => [
				'PostFavorite.post_id' => $id
			],
		]);
		$result['PostFavorite']['count'] = $favoriteCount;

		// 閲覧ユーザがお気に入りしているかを取得
		$isFavorite = 0;
		if (isset($this->viewVars['authUser'])) {
			$userId = $this->viewVars['authUser']['id'];
			$isFavorite = $this->PostFavorite->find('count', [
				'conditions' => [
					'PostFavorite.user_id' => $userId,
					'PostFavorite.post_id' => $id
				],
			]);
		}
		// $isFavoriteはcountの結果のままなのでbooleanにする
		$result['PostFavorite']['isFavorite'] = ($isFavorite > 0);

		$this->set('post', $result);
	}

	// deny
	public function add() {
		$this->loadModel('Tag');
		$tags = $this->Tag->find('all');
		$this->set('tags', $tags);

		if ($this->request->is('post')) {
			// todo ここでpostにuserIdをセットしたい
			//      現在はviewのformにinput:hiddenでセットしている
			// $userId = $this->viewVars['authUser']['id'];
			// $this->request->data['user_id'] = $userId;


			// formで選択されたtagの配列からTagRelation配列を作成し、Postと一緒にsaveAllする
			$newData['Post'] = $this->request->data['Post'];

			$this->log('check test : '.implode($this->request->data['Post']['Tag']), LOG_DEBUG);
			foreach ($this->request->data['Post']['Tag'] as $key => $tagId) {
				$newData['TagRelation'][$key]['tag_id'] = $tagId;
			}

			if ($this->Post->saveAll($newData)) {
				//うまく行った場合
				$this->Session->setFlash('success!');
				$this->redirect(array('action'=>'index'));
			} else {
				//うまく行かなかった場合
				$this->Session->setFlash('failed!');
			}
		}
	}

	// deny
	public function edit($id = null) {
		$this->Post->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Post->read();
		} else {

			// 投稿者本人でなければException
			$userId = $this->viewVars['authUser']['id'];
			if (!$this->Post->isAuthor($userId, $id)) {
				throw new Exception('not authorized');
			}

			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash('success!');
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash('failed!');
			}
		}
	}

	// deny
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		// 投稿者本人でなければException
		$userId = $this->viewVars['authUser']['id'];
		if (!$this->Post->isAuthor($userId, $id)) {
			throw new Exception('not authorized');
		}

		// post:$idで削除する場合
		// if ($this->Post->delete($id)) {
		// 	$this->Session->setFlash('Deleted!');
		// 	$this->redirect(array('action'=>'index'));
		// }

		// ajaxで削除する場合
		if ($this->request->is('ajax')) {
			if ($this->Post->delete($id)) {
				$this->autoRender = false;
				$this->autoLayout = false;
				$response = array('id' => $id);
				$this->header('Content-Type: application/json');
				echo json_encode($response);
				exit();
			}
		}
		$this->redirect(array('action' => 'index'));
	}
}

?>