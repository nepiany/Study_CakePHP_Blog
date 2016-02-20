<?php $this->assign('title', '記事一覧です(top page)'); ?>

<h2>記事一覧(トップページ)</h2>

<ul>

<?php foreach($posts as $post) : ?>
	<li id="post_<?php echo h($post['Post']['id']); ?>">
	<?php
		// debug($post); // デバッグメッセージ
		echo $this->Html->link($post['Post']['title'], '/posts/view/'.$post['Post']['id']);
	?>
	<small>
		written by
		<?php
			echo h($post['User']['nickname']).' ';
		?>
	</small>
	<?php
		// 投稿ユーザならば編集・削除できる
		if (isset($authUser) && $post['User']['id'] === $authUser['id']) {
			echo $this->Html->link('編集', array('action'=>'edit', $post['Post']['id'])).' ';

			// 直接以下のリンクでも削除できる
			// echo $this->Form->postLink('削除', array('action'=>'delete', $post['Post']['id']), array('confirm'=>'sure?'));

			echo $this->Html->link('削除', '#', array('class' => 'delete', 'data-post-id' => $post['Post']['id']));
		}
	?>
	</li>
<?php endforeach; ?>

</ul>

<?php if (isset($authUser)) : ?>

	<h2>Add Post</h2>
	<?php
		echo $this->Html->link('Add post', array('controller'=>'posts', 'action'=>'add'));
	?>

<?php endif; ?>


<script>
$(function () {
		$('a.delete').click(function (e) {
			if (confirm('sure?')) {
				$.post('posts/delete/' + $(this).data('post-id'), {}, function (res) {
						$('#post_'+res.id).fadeOut();
				}, 'json');
			}
			return false;
		});
});
</script>