<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->deny('index', 'logout');
		$this->Auth->allow('register', 'login');
	}

	public function index() {
		// /users/のインデックスは無しにしたいので、非ログイン時はログイン、ログイン済みなら/posts/index/にリダイレクト
		// todo ユーザごとマイページ作成
		if (isset($this->viewVars['authUser'])) {
			$this->redirect(array('controller'=>'posts', 'action'=>'index'));
		} else {
			$this->redirect('login');
		}
	}

	public function register() {
		if($this->request->is('post') && $this->User->save($this->request->data)) {
			//ログイン
			$this->Auth->login();
			$this->redirect(array('controller'=>'posts', 'action'=>'index'));
		}
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect(array('controller'=>'posts', 'action'=>'index'));
			} else {
				$this->Session->setFlash('login failed...');
			}
		}
	}

	public function logout() {
		$this->Auth->logout();
		$this->Session->setFlash('logout!');
		$this->redirect('login');
	}

}

?>