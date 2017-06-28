<script type="text/javascript">
<!--
	function check(){
		return window.confirm('削除してもよろしいですか？');
	}

// -->
</script>
<?= Form::open('admin/edit/' . $user_id); ?>
	<table>	
			<?php foreach ($user as $key => $val): ?>
				<tr style="margin:10px;">
					<td style="text-align: right;">
						<span style="padding:10px;"><?= $key ?> : </span>
					</td>
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