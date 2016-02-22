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
				// todo 以下のように、ヘルパー作ってisAutherでチェックしたい
				// if ($this->Post->isAuthor($authUser['id'], $post['Post']['id'])) {
				if ($authUser['id'] === $post['Post']['user_id']) {
					echo $this->Html->link('編集', array('action'=>'edit', $post['Post']['id']));
				} else {
					echo $this->Form->input('お気に入り', array('type'=>'checkbox', 'id'=>'tgl_favorite', 'data-post-id'=>$post['Post']['id']));
				}
			} else {
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
		<?php echo $this->Html->link('削除', '#', array('class'=>'btn-comment-delete', 'data-comment-id'=>$comment['id']));
		?>
	</li>
<?php endforeach; ?>
</ul>

<h3>Add Comment</h3>

<?php echo $this->Form->create('Comment', array('action' => 'add'));
	echo $this->Form->input('commenter');
	echo $this->Form->input('body', array('rows'=>3));
	echo $this->Form->input('post_id', array('type'=>'hidden', 'value'=>$post['Post']['id']));

	echo $this->Form->end('Save Comment');
?>

<script>
$(function () {
	$('.btn-comment-delete').click(function (e) {
		if (confirm('sure?')) {
			// todo 以下deleteのパスを相対指定でなくする
			$.post('../../comments/delete/'+$(this).data('comment-id'),
				{},
				function (res) {
					$('#comment_' + res.id).fadeOut();
				},
				'json'
			);
		}
		return false;
	});

	$('#tgl_favorite').click(function (e) {
		if ($(this).prop('checked')) {
			// alert('add favorite' + $(this).data('post-id'));
			$.post(
				'../addFavorite/' + $(this).data('post-id'),
				{},
				null,
				'json'
			);
		} else {
			// alert('remove favorite' + $(this).data('post-id'));
			$.post(
				'../removeFavorite/' + $(this).data('post-id'),
				{},
				null,
				'json'
			);
		}
	});
});
</script>