<!-- 入力フォーム -->
あなたのIDは<?= $newId ?>です。<br>
８文字以内で名前を入力してください。
<form method="post" action=<?= CONTENTS_URL.'admin/create' ?> >
	<input type='hidden' name='newId' value='<?= $newId ?>'>
	name:<input type='text' name='userName' maxlength="8" size="20">
	
	<input type='submit'  value="ゲーム開始">
</form>

<div>
	<a href="<?= ADMIN_URL ?>">
		管理画面に戻る
	</a>
</div>
