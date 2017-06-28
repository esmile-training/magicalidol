<?php //CSS  ?>
<?= Asset::css("admin/screen_size_max.css"); ?>
<style type="text/css">
	#enemmy_img {
		width: 150px;
	}
	.enemmy_list {
		border-collapse: collapse;
	}
	.enemmy_list td {
		border:1px #FFF solid;
		padding: 5px;
	}
</style>

<?php //敵リスト ?>
<table class="enemmy_list">
	<?php foreach($enemmy_mst as $enemmy): ?>
		<tr>
			<td>
				<?= $enemmy['id'] ?>
			</td>
			<td>
				<?= $enemmy['name'] ?>
			</td>
			<td style="">
				<?= Asset::img(	'enemmy/'.$enemmy['id'].'.png',
						array('id'=>'enemmy_img')	
				) ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>


