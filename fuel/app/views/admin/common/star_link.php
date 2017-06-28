<table>
	<tr>
		<td>
			<?= Asset::img('admin/star.png',
				array(
					'id' => 'admin_top_menu_img',
					'style' => 'vertical-align:middle; width:17px;'
				)
		   ) ?>
		</td>
		<td>
			<?= Html::anchor(ADMIN_URL . $url, 	$str); ?>
		</td>
	</tr>
</table>