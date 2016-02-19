<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {
	//読み込むコンポーネントの指定
	public $components = array('Session', 'Auth');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow('register', 'login');
	}

	public function index() {
		$this->set('user', $this->Auth->user());
	}

}

?>