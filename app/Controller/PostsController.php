<?php

class PostsController extends AppController {
	// public $scaffold;
	// public $helpers = array('Html', 'Form');

	public function index() {
		// $params = array(
		// 	'order' => 'modified desc',
		// 	'limit' => 2
		// );
		// $this->set('posts', $this->Post->find('all', $params));
		$this->set('posts', $this->Post->find('all'));
		// $this->set('title_for_layout', '記事一覧');
	}

	public function view($id = null) {
		$this->Post->id = $id;
		$this->set('post', $this->Post->read());
	}

	public function add() {
		if ($this->request->is('post')) {

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

	public function edit($id = null) {
		$this->Post->id = $id;
		if ($this->request->is('get')) {
			$this->request->data = $this->Post->read();
		} else {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash('success!');
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash('failed!');
			}
		}
	}

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