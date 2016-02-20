<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('Session',
		'Auth' => array(
			// 以下はデフォルトと同じ設定なので必要ない
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login'
			),
			'loginRedirect' => array(
				'controller' => 'users',
				'action' => 'login'
			),
			'logoutRedirect' => array(
				'controller' => 'users',
				'action' => 'login'
			),
			'authError' => 'emailとパスワードを確認してください。', // todo これ何？
			'authenticate' => array(
				'Form' => array(
					'fields' => array(
						'username' => 'email',
					)
				)
			)
    	)
    );

    public function beforeFilter() {
    	parent::beforeFilter();

    	// ログインが必要かどうかの設定
		// ここでは全許可して、要ログインのものは個別のコントローラで制御
		$this->Auth->allow();
		if ($this->Auth->loggedIn()) {
			// 無効なユーザの場合はログアウトさせる
			// if (!$this->User->isValid($this->Auth->user('id'))) {
			// 	$this->Auth->logout();
			// }
			// ユーザ情報をViewで利用可能にしておく
			$this->set('authUser', $this->Auth->user());
		}
    }
}
