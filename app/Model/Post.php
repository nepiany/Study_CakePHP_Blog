<?php

class Post extends AppModel {
	public $belongsTo = 'User';
	public $hasMany = [
		'Comment',
		'TagRelation'=>[
			'className' => 'TagRelation',
            'foreignKey' => 'post_id'
		]
	];

	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => '空じゃダメよ'
		),
		'body' => array(
			'rule' => 'notEmpty'
		)
	);

	public function isAuthor($userId, $postId) {
		$result = (bool)$this->find('count', [
			'conditions' => [
				$this->alias.'.id' => $postId,
				$this->alias.'.user_id' => $userId,
			],
		]);

		return $result;
	}
}

?>