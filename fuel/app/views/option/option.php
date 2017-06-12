<?php echo Asset::css('option.css'); ?>

<div>
	<div class="nameChange">
		名前変更
	</div>
	<div>
		<form action="<?= CONTENTS_URL.'option/namechange' ?>" method="post" name="namechangeForm">
			<input type="text" name="aftername" class="afternameForm"><br><input type="submit" value="名前を変更する" class="nameChangeSubmit">
		</form>
	</div>
</div>

<div>
	<div class="speedChange">
		戦闘速度変更
	</div>
	<div>
		<form action="<?= CONTENTS_URL.'option/speedchange' ?>" method="post" name="speedchangeForm">
			<select onchange="document.speedchangeForm.submit()" name="changeSpeed" class="speedchangeForm">
				<?php foreach($battleSpeed as $speed) : ?>
					<?php if($speed == $nowSpeed) : ?>
						<option value="<?= $speed ?>"selected>×<?= $speed ?></option>
					<?php else : ?>
						<option value="<?= $speed ?>">×<?= $speed ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</form>
	</div>
</div>

<a href="<?= CONTENTS_URL.'mypage'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>