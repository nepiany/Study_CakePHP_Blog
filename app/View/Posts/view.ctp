<h2>
	<?php echo h($post['Post']['title']); ?>
</h2>

<p>
	<?php echo h($post['Post']['body']); ?>
</p>

<p>
	<small>
		<?php
			if (isset($authUser)) {
				// if ($this->Post->isAuthor($authUser['id'], $post['Post']['id'])) {
				if ($authUser['id'] === $post['Post']['user_id']) {
					echo $this->Html->link('編集', array('action'=>'edit', $post['Post']['id']));
				} else {
					// todo お気に入り状態に応じて見た目を変える
					echo $this->Html->link('お気に入り', 'addFavorite');
				}
			} else {
				// todo ログインへのリンク
				echo $this->Html->link('会員になればお気に入りできます', array('controller'=>'users', 'action'=>'login'));
			}
		?>
	</small>
</p>

<h2>Comments</h2>

<ul>
<?php foreach ($post['Comment'] as $comment) : ?>
	<li id="comment_<?php echo h($comment['id']); ?>">
		<?php echo h($comment['body']).' by '.h($comment['commenter']); ?>
		<?php echo $this->Html->link('削除', '#', array('class'=>'delete', 'data-comment-id'=>$comment['id']));
		?>
	</li>
<?php endforeach; ?>
</ul>

<h3>Add Comment</h3>

<?php echo $this->Form->create('Comment', array('action' => 'add'));
	echo $this->Form->input('commenter');
	echo $this->Form->input('body', array('rows'=>3));
	echo $this->Form->input('Comment.post_id', array('type'=>'hidden', 'value'=>$post['Post']['id']));

	echo $this->Form->end('Save Comment');
?>

<script>
$(function () {
	$('a.delete').click(function (e) {
		if (confirm('sure?')) {
			$.post('../../comments/delete/'+$(this).data('comment-id'), {}, function
				(res) {
				$('#comment_' + res.id).fadeOut();

			}, 'json');
		}
		return false;
	});
})
</script>