<?php

class PostsController extends AppController {
	// public $scaffold;
	// public $helpers = array('Html', 'Form'); // ←これはデフォルトで使えるみたい

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->deny('add', 'edit', 'delete', 'addFavorite', 'removeFavorite');
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
		$this->set('post', $this->Post->read());
	}

	// deny
	public function add() {

		if ($this->request->is('post')) {
			// todo ここでpostにuserIdをセットしたい
			//      現在はviewのformにinput:hiddenでセットしている

			// $userId = $this->viewVars['authUser']['id'];
			// $this->request->data['user_id'] = $userId;

			if ($this->Post->save($this->request->data)) {
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
		// post:$idで削除する場合
		// if ($this->Post->delete($id)) {
		// 	$this->Session->setFlash('Deleted!');
		// 	$this->redirect(array('action'=>'index'));
		// }

		// ajaxで削除する場合
		if ($this->request->is('ajax')) {
			if ($this->Post->delete($id)) {
				// 投稿者本人でなければException
				$userId = $this->viewVars['authUser']['id'];
				if (!$this->Post->isAuthor($userId, $id)) {
					throw new Exception('not authorized');
				}

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

	// deny
	public function addFavorite($postId) {
		$this->Session->setFlash('add favorite');
		// $this->PostFavorite->save([
		// 	'user_id'=>''
		// ]);
	}

	// deny
	public function removeFavorite($postId) {
		$this->Session->setFlash('remove favorite');
	}
}

?>