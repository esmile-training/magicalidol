<!-- css  -->
<?= Asset::css("home.css"); ?>


<div class="home_top_title">
	magicalidol
</div>

<h3>config</h3>
<?php foreach($config as $key => $value): ?>
	<?= '<div>' . $key . ' : ' . $value . '</div>'; ?>
<?php endforeach; ?>

<h3>画像</h3>
<div>
	<?= Asset::img(
		'background.jpg',
		 array('width'=>'50%', 'alt'=>'chara')
	) ?>
<div>

<h3>imgでのリンク</h3>
<div><?php echo $img; ?></div>

<div>
	<a href="<?= CONTENTS_URL.'mypage' ?>">
		仮マイページ
	</a>
</div>