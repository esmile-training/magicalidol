<?php echo Asset::css('avatarcategory.css'); ?>

<div>
	<?php foreach($categoryList as $key => $value): ?>
		<div class="avatarSelect<?= $value['code'] ?>">
			<a href="<?= CONTENTS_URL.'avatar/selectAvatar/'.$value['code'] ?>">
			</a>
		</div>
	<?php endforeach; ?>
</div>

<a href="<?= CONTENTS_URL.'equipment'?>">
	<div class="backButton">
			<?= Asset::img( 'btn/bBack03.png',
				array('class'=>'backButton', 'alt'=>'戻る')
			); ?>
	</div>
</a>