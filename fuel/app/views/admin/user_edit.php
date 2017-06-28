<script type="text/javascript">
<!--
	function check(){
		return window.confirm('削除してもよろしいですか？');
	}

// -->
</script>
<style type="text/css">
	.edit_list {
		border-collapse: collapse;
	}
	.edit_list td, th {
		border:1px #777 solid;
		padding: 5px;
	}
	.edit_list th {
		background-color:#AA3300;
	}
	.edit_list td {
		background-color:#EEE;
		color: #111;
	}
</style>
<?= Form::open('admin/edit/' . $user_id); ?>
	<table class="edit_list">	
			<?php foreach ($user as $key => $val): ?>
				<tr style="margin:10px;">
					<th style="text-align: right; padding:10px;">
						<?= $key ?>
					</th>
					<td >
						<?php if( in_array($key, array("id", "updated_at ")) ): ?>
							<?= $val ?>
						<?php else: ?>
							<?= Form::input($key, $val, array( 'style' => 'padding:3px;')); ?>
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
	</table>
	<table style="width:300px; text-align:center; margin:10px 0px;">
			<tr>
				<td style="text-align:center;">
					<?= Form::button('delete', '削除', array('type' => 'submit', 'value' => 1, 'onClick' => 'return check()', 'style' => 'padding: 2px;')); ?>
				</td>
				<td style="text-align:center;">
					<?= Form::button(null, '更新', array('type' => 'submit', 'style' => 'padding: 2px;')); ?>
				</td>
			</tr>
	</table>
<?=  Form::close(); ?>

<?= View::forge('admin/common/star_link',
		array('str' => 'リストに戻る', 'url' => 'user_list')
);?>