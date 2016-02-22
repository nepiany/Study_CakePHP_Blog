<?php

class PostFavorite extends AppModel {
	public $belongsTo = array('User', 'Post');
	// todo User, PostにhasManyは必要？
}

?>