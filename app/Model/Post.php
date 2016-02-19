<?php

class Post extends AppModel {
	public $hasMany = 'Comment';
	// public $belongsTo = 'User';

	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'からじゃダメよ'
		),
		'body' => array(
			'rule' => 'notEmpty'
		)
	);
}

?>