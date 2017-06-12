<?php echo Asset::css('admin.css'); ?>

<table class="newsList">
	<tr>
		<th>ID</th>
		<th>タイトル</th>
		<th>開始日時</th>
		<th>終了日時</th>
		<th></th>
	</tr>
	<?php foreach($newsList as $news): ?>
		<form action="<?= ADMIN_URL.'editNews' ?>" method="post" name="news<?= $news['id'] ?>">
			<input type="hidden" name="id" value="<?= $news['id'] ?>">
			<tr>
				<td><?= $news['id'] ?></td>
				<td><?= $news['title'] ?></td>
				<td><?= $news['start'] ?></td>
				<td><?= $news['end'] ?></td>
				<td><a href="#" onclick="document.news<?= $news['id'] ?>.submit()">編集</a></td>
			</tr>
		</form>
	<?php endforeach; ?>
</table>
<p>
	<form action="<?= ADMIN_URL.'editNews' ?>" method="post" name="news0">
		<input type="hidden" name="id" value="0">
		<a href="#" onclick="document.news0.submit()">新規登録</a>
	</form>
</p>
<p>
	<a href="<?= ADMIN_URL ?>">戻る</a>
</p>