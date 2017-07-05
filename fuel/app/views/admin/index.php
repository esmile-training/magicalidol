<?php //CSS  ?>
<style type="text/css">
	#admin_top_title {
		text-align: center;
	}

	#admin_top_title_img {
		margin: 10px 0px;
		width: 500px;
		background-color: #FFFFFF;
	}
</style>

<?php //タイトル画像 /　画像リンク ?>
<div id="admin_top_title">
	<?= Html::anchor( CONTENTS_URL . 'top',	
			Asset::img(	'admin/title.png',
				 array('id'=>'admin_top_title_img')	
			)
	) ?>
</div>

<?php //メニュー  ?>
<?= View::forge('admin/common/star_link',
		array('str' => 'ユーザ編集', 'url' => 'user_list')
);?>
<?= View::forge('admin/common/star_link',
		array('str' => '魔物リスト', 'url' => 'ennemy_list')
);?>
<?= View::forge('admin/common/star_link',
		array('str' => 'スタッフロール', 'url' => 'staff')
);?>
<?= View::forge('admin/common/star_link',
		array('str' => 'ポップアップ', 'url' => 'popup')
);?>