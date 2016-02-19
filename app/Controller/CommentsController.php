<?php

class CommentsController extends AppController {
	// public $helpers = array('Html', 'Form');

	public function add() {
		if ($this->request->is('post')) {

			if ($this->Comment->save($this->request->data)) {
				//うまく行った場合
				$this->Session->setFlash('success!');
				$this->redirect(array('controller'=>'posts', 'action'=>'view', $this->data['Comment']['post_id']));
			} else {
				//うまく行かなかった場合
				$this->Session->setFlash('failed!');
			}
		}
	}

	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		// ajaxで削除する場合
		if ($this->request->is('ajax')) {
			if ($this->Comment->delete($id)) {
				$this->autoRender = false;
				$this->autoLayout = false;
				$response = array('id' => $id);
				$this->header('Content-Type: application/json');
				echo json_encode($response);
				exit();
			}
		}
		$this->redirect(array('controller'=>'posts', 'action' => 'view'));
	}
}

?>