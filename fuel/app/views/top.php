<?php //検索フォーム ?>
<?= Form::open(array('action' => 'top/login', 'method' => 'get')); ?>
	<table>
		<tr>
			<td>ID：</td>
			<td>
				<?= Form::input('user_id',  '', array(	'style' => 'padding:3px;', 'placeholder' => 'IN検索(カンマ区切り)' )); ?>
			</td>
			<td>名前:</td>
			<td>
				<?= Form::input('user_name', '', array( 'style' => 'padding:3px;', 'placeholder' => 'LIKE検索')); ?>
			</td>
			<td>
				<?= Form::button(null, '検索', array('type' => 'submit', 'style' => 'padding: 2px;')); ?>
			</td>
			<td>
				<?= Html::anchor(CONTENTS_URL . 'top', 'リセット'); ?>
			</td>
		</tr>
	</table>
<?=  Form::close(); ?>

<?php if(isset($unauth_login)): ?>
	<div>
		IDが間違っています。
	</div>
<?php endif; ?>


