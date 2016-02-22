<?php

class PostFavorite extends AppModel {
	$belongsTo = array('User', 'Post');
	// todo User, PostにhasManyは必要？
}

?>