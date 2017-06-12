<?php echo Asset::css('avatarshop.css'); ?>
<?php echo Asset::css('avatarcategory.css'); ?>
<div>
	<?= Asset::img( 'shop/hukuyaTop.png',
		array(  'width'=> '100%','alt'=>'服屋')
	); ?>
</div>

<div>
	<?php foreach($avatarCategory as $category): ?>
		<div class="avatarSelect<?= $category['code'] ?>">
			<a href="<?= CONTENTS_URL.'avatarshop/index/'.$category['code'] ?>">
			</a>
		</div>
	<?php endforeach; ?>
</div>

<a href="<?= CONTENTS_URL.'shop'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>