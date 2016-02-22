<h2>Add post</h2>

<?php
	echo $this->Form->create('Post');
	echo $this->Form->input('title', array('required'=>false));
	echo $this->Form->input('body', array('rows'=>3));
	// ログインしていないとログイン画面にリダイレクトされるのでidは必ず存在
	// todo 本当はコントローラの方でidをセットしたい

	// 複数選択に対応するため、checkboxを生成し、
	// checked状態の配列をaddアクションでTagRelationの配列にしてからsaveAllしている
	// todo ↑JSでそのままTagRelation配列を送信できるようにしたい
	$options = [];
	foreach ($tags as $tag) {
		$options[$tag['Tag']['id']] = $tag['Tag']['name'];
	}
	echo $this->Form->select('Tag',
		$options,
		[
			'type'=>'select',
			'multiple'=>'checkbox'
		]
	);

	echo $this->Form->input('user_id', array('type'=>'hidden', 'value'=>$authUser['id']));
	echo $this->Form->end('Save Post');
?>