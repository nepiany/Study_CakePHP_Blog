<h2>ログイン</h2>
<?php print(
	$this->Form->create('User') .
// todo	$this->Form->input('email', array('type'=>'text')) .
	$this->Form->input('email') .
	$this->Form->input('password') .
	$this->Form->end('ログイン')
); ?>