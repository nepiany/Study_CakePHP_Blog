<h2>Add post</h2>

<?php
	echo $this->Form->create('Post');
	echo $this->Form->input('title', array('required'=>false));
	echo $this->Form->input('body', array('rows'=>3));
	// todo ログインしていない場合の処理
	echo $this->Form->input('user_id', array('type'=>'hidden', 'value'=>$authUser['id']));
	echo $this->Form->end('Save Post');
?>