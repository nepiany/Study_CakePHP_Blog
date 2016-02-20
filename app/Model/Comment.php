<?php

class Comment extends AppModel {
	public $belongsTo = 'Post';
	// public $belongsTo = array('User', 'Post');
	// public $validate = array(
	// 	'title' => array(
	// 		'rule' => 'notEmpty',
	// 		'message' => 'からじゃダメよ'
	// 	),
	// 	'body' => array(
	// 		'rule' => 'notEmpty'
	// 	)
	// );
}

?>