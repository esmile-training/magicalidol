<?php //CSS  ?>
<style type="text/css">
	#container .user_list a {
		color: #0086b3;
	}
	.user_list {
		border-collapse: collapse;
	}
	.user_list td, th {
		border:1px #777 solid;
		padding: 8px;
	}
	.user_list th {
		background-color:#333;
	}
	.user_list td {
		background-color:#EEE;
		color: #111;
	}
	
	#status{
		width: 350px;
		height: 415px;
		background-color: white;
		float: right;
		margin-top: -424px;
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
			<td>
				<button 
					type="button" 
					name="aaa" 
					value="aaa" 
					onClick="connection('http://esmile-sys.sakura.ne.jp/magicalidol/mizugashira/base/ajax/post_data/<?= $user->id ?>', 'user_ajax')">
					開発者確認
				</button>
			</td>
		</tr>
	<?php endforeach; ?>
</table>



	<div id="status">
		<table class="user_list" style ="margin:10px;">
			<tr>
				<th>ID</th>
				<td id="user_id"></td>
			</tr>
			<tr>
				<th>状態</th>
				<td id="state"></td>
			</tr>
			<tr>
				<th>debug_time</th>
				<td>
					<?= Form::input('debug', '', array(	'style' => 'padding:3px;' )); ?>
				</td>
			</tr>
		</table>
		<?= Form::button(
			null, 
			'切替', 
			array(
				'id' => 'chenge',
				'type' => 'submit', 
				'style' => 'padding: 2px;')
			); 
		?>
		<?= Form::button(null, '更新', array('type' => 'submit', 'style' => 'padding: 2px;')); ?>
	</div>


<?php //ページャ ?>
<div>
	<?php echo Pagination::create_links(); ?>
</div>


<script>
// データがある場合
function ajax_binder(data)
{
	// どのデータなのか判定
	if(data.type === "user_ajax")
	{
		// タグに情報を付加
		$('#user_id').text(data['id']);
		$('#state').text('開発者');
		$('#form_debug').attr('value', data['debug_time']);
		
		var element = document.getElementById("chenge");
		element.setAttribute("onClick", "connection('http://esmile-sys.sakura.ne.jp/magicalidol/mizugashira/base/ajax/chenge_developer/" + data['id'] + "', 'chenge_user_ajax')");
	}
}

// データがない場合
function ajax_isnull(data)
{
	$('#user_id').text(data['id']);
	$('#state').text('一般ユーザ');
	$('#form_debug').attr('value', '');
}
</script>