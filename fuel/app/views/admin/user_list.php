<?php //CSS  ?>
<style type="text/css">
	#container .user_list a {
		color: #0086b3;
	}
	.user_list {
		border-collapse: collapse;
	}
	.user_list td, th {
		border:1px #FFF solid;
		padding: 8px;
	}
	.user_list th {
		background-color:#333;
	}
	.user_list td {
		background-color:#DDD;
		color: #111;
	}
</style>

<?php //検索フォーム ?>
<?= Form::open(array('action' => 'admin/user_list', 'method' => 'get')); ?>
	<table>
		<tr>
			<td>ID：</td>
			<td>
				<?= Form::input('user_id', $user_id, array(	'style' => 'padding:3px;', 'placeholder' => 'IN検索(カンマ区切り)' )); ?>
			</td>
			<td>名前:</td>
			<td>
				<?= Form::input('user_name', $user_name, array( 'style' => 'padding:3px;', 'placeholder' => 'LIKE検索')); ?>
			</td>
			<td>
				<?= Form::button(null, '検索', array('type' => 'submit', 'style' => 'padding: 2px;')); ?>
			</td>
			<td>
				<?= Html::anchor(ADMIN_URL . 'user_list', 'リセット'); ?>
			</td>
		</tr>
	</table>
<?=  Form::close(); ?>

<?php //ユーザリスト ?>
<table class="user_list" style ="margin:10px;">
	<tr>
		<th>ID</th>
		<th>名前</th>
		<th>最終更新日時</th>
		<th>作成日時</th>
		<th></th>
	</tr>
	<?php foreach ($user_list as $user): ?>
		<tr>
			<td>
				<?= $user->id ?>
			</td>
			<td>
				<?= $user->name ?>
			</td>
			<td>
				<?= $user->updated_at ?>
			</td>
			<td>
				<?= $user->created_at ?>
			</td>
			<td>
				<?= Html::anchor(ADMIN_URL . 'user_edit/'.$user->id, "編集"); ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<?php //ページャ ?>
<div>
	<?php echo Pagination::create_links(); ?>
</div>
