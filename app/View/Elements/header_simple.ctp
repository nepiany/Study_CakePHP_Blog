<h1>
	<?php echo $this->Html->link('Home', '/').' '; ?>
	<small>
		<?php
			if (isset($authUser)) {
				echo h($authUser['nickname']).'さん ';
				echo $this->Html->link('ログアウト', array('controller'=>'users', 'action'=>'logout'));
			} else {
				echo $this->Html->link('ログイン', array('controller'=>'users', 'action'=>'login')).' または ';
				echo $this->Html->link('新規登録', array('controller'=>'users', 'action'=>'register'));
			}
		?>
	</small>
</h1>