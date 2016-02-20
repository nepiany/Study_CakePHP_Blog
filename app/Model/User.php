<?php

App::uses('AppModel', 'Model');

class User extends AppModel {
	public $hasMany = array('Post', 'Comment');

	public $validate = array(
		'email' => array(
			array(
				'rule' => 'isUnique', //重複禁止
				'message' => '既に使用されている名前です。'
			),
			array(
				'rule' => 'email',
				'message' => 'メールアドレスを入力してください。'
			),
			array(
				'rule' => array('between', 3, 255),
				'message' => 'emailは3文字以上255文字以内にしてください。'
			)
		),
		'nickname' => array(
			array(
				'rule' => 'alphaNumeric',
				'message' => 'ニックネームは半角、全角の英数字にしてください。'
			),
			array(
				'rule' => array('between', 3, 255),
				'message' => 'ニックネームは3文字以上255文字以内にしてください。'
			)
		),
		'password' => array(
			array(
				'rule' => 'alphaNumeric',
				'message' => 'パスワードは半角英数字にしてください。'
			),
			array(
				'rule' => array('between', 1, 64),
				'message' => 'パスワード形式がおかしいみたい。'
			)
		)
	);

	public function beforeSave($options = array()) {
		$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		return true;
	}
}

?>