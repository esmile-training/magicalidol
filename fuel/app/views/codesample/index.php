<!-- css  -->
<?= Asset::css("style.css"); ?>


<div class="home_top_title">
	CSSによって大きく表示させています。
</div>

<h3>config</h3>
<?php foreach($config as $key => $value): ?>
	<?= '<div>' . $key . ' : ' . $value . '</div>'; ?>
<?php endforeach; ?>

<h3>画像</h3>
<div>
	<?= Asset::img(
		'img1.png',
		 array('width'=>'50%', 'alt'=>'chara')
	) ?>
<div>

<h3>imgでのリンク</h3>
<div>
<?php echo $img; ?></div>

<h3>データベースからの取得</h3>
<div>
	<pre>
		<?php var_dump($relation); ?>
	</pre>
</div>
<h4>↑利用例</h4>
<div>
	<?php foreach($relation as $value): ?>
		<?= '<div>' . $value['productName'] . '</div>'; ?>
	<?php endforeach; ?>
	
</div>
<br>

<h3>aタグ</h3>
<div>
	<a href="<?= CONTENTS_URL.'mypage' ?>">
		仮マイページ
	</a>
</div>