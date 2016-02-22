<?php

// これは必要？
App::uses('AppController', 'Controller');

class PostFavoritesController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->deny('add', 'delete');
	}

	// deny
	public function add($postId) {
		if ($this->request->is('ajax')) {

			$userId = $this->viewVars['authUser']['id'];

			// todo 本当は重複チェックしたい
			$result = $this->PostFavorite->save([
				'user_id'=>$userId,
				'post_id'=>$postId
			]);

			if ($result) {
				$this->autoRender = false;
				$this->autoLayout = false;
				$response = array('id' => $postId);
				$this->header('Content-Type: application/json');
				echo json_encode($response);
				exit();
			}
		}
	}

	// deny
	public function delete($postId) {
		if ($this->request->is('ajax')) {

			$userId = $this->viewVars['authUser']['id'];

			// todo PostFavorite.が必要な理由は？
			$params = ['PostFavorite.user_id'=>$userId, 'PostFavorite.post_id'=>$postId];
			$result = $this->PostFavorite->deleteAll($params);

			if ($result) {
				$this->autoRender = false;
				$this->autoLayout = false;
				$response = array('id' => $postId);
				$this->header('Content-Type: application/json');
				echo json_encode($response);
				exit();
			}

		}
	}

}

?>