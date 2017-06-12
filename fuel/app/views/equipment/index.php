<?php echo Asset::css('selectequipment.css'); ?>
<div>
	<p>装備</p>
	<a href="<?= CONTENTS_URL.'weapon'?>"><div class='weapon'></div></a>
	<a href="<?= CONTENTS_URL.'armor'?>"><div class='armor'></div></a>
	<a href="<?= CONTENTS_URL.'avatar'?>"><div class='avatar'></div></a>
	<a href="<?= CONTENTS_URL.'room'?>"><div class='room'></div></a>
</div>

<a href="<?= CONTENTS_URL.'equipment/submit'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>
