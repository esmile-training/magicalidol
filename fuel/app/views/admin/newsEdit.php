<?php echo Asset::css('editNews.css'); ?>

<form action="<?= ADMIN_URL.'submitNews' ?>" method="post">
	<table>
		<tr>
			<th>ID</th>
			<td><input type="text" name="id" readonly value="<?= $newsData['id'] ?>"></td>
		</tr>
		<tr>
			<th>タイトル</th>
			<td><textarea name="title" class="editTitle"><?= $newsData['title'] ?></textarea></td>
		</tr>
		<tr>
			<th>開始日時</th>
			<td><input type="datetime-local" name="start" value="<?= $newsData['start'] ?>"></td>
		</tr>
		<tr>
			<th>終了日時</th>
			<td><input type="datetime-local" name="end" value="<?= $newsData['end'] ?>"></td>
		</tr>
		<tr>
			<th>本文</th>
			<td>
				<textarea name="text" class="editText"><?= $newsData['text'] ?></textarea><br>
				[img:imgフォルダ以下の画像URL]で画像を挿入できます。
			</td>
		</tr>
	</table>
	<input type="submit" value="送信">
</form>
<p>
	<a href="<?= ADMIN_URL."editNews" ?>">戻る</a>
</p>