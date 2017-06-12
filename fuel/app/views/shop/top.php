<?php echo Asset::css('shop.css'); ?>
<div class="button">
	<a href="<?= CONTENTS_URL.'weapongacha'?>">
		<div class="weapongachaButton">
		</div>
	</a>
</div>
<div class="button">
	<a href="<?= CONTENTS_URL.'armorshop'?>">
		<div class="armorshopButton">
		</div>
	</a>
</div>
<div class="button">
	<a href="<?= CONTENTS_URL.'avatarshop/select'?>">
		<div class="avatarshopButton">
		</div>
	</a>
</div>
<div class="button">
	<a href="<?= CONTENTS_URL.'itemshop'?>">
		<div class="itemshopButton">
		</div>
	</a>
</div>
<div class="button">
	<a href="<?= CONTENTS_URL.'roomshop'?>">
		<div class="roomshopButton">
		</div>
	</a>
</div>
<div>
	<a href="<?= CONTENTS_URL.'eventshop'?>">
		<div class="eventshopButton">
		</div>
	</a>
</div>

<a href="<?= CONTENTS_URL.'mypage'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>