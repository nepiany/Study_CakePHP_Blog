<h2>新規登録</h2>
<?php echo
	$this->Form->create('User') .
	// $this->Form->input('email', array('type'=>'text')) .
	$this->Form->input('email') .
	$this->Form->input('nickname') .
	$this->Form->input('password') .
	$this->Form->end('新規登録')
?>