<?php echo Asset::css('equipment.css'); ?>
<?php echo Asset::js('equipment.js'); ?>

<?php if($result): ?>
	<div class="modalSuccess" id="result">
		<div class="successRelative">
			<div class="successText">
				装備を変更しました
			</div>
			<?= Asset::img( 'btn/ok.png',
				array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
			); ?>
		</div>
	</div>
<?php endif; ?>

<p>装備中のアバター</p>

<div class="equipment">
	<?php $nowAvatar = $equipAvatar['id']; ?>
	<?= Asset::img( $equipAvatar['thumbnail'],
		array('class'=>'thumbnail', 'alt'=>'アバター')
	); ?>
	<div class="name">
		<?= $equipAvatar['name']; ?>
	</div>
	<div class="status">
		HP+<?= $equipAvatar['hitPoint'] ?>
	</div>
	<div class="skill">
		回避+<?= $equipAvatar['luckPoint'] ?>
	</div>
</div>

<p>装備一覧</p>
<p>
	<form action="<?= CONTENTS_URL.'avatar/selectAvatar/'.$categoryCode ?>" method="post" name="sortForm">
		<input type="hidden" name="page" value="1">
		<select name="sort" onchange="document.sortForm.submit()">
		<?php foreach($sortType as $id=>$value): ?>
			<?php if($id == $sort): ?>
				<option value="<?= $id; ?>" selected><?= $value; ?></option>
			<?php else: ?>
				<option value="<?= $id; ?>"><?= $value; ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
		</select>
	</form>
</p>
<?php foreach($userAvatar as $avatar): ?>
	<form action="<?= CONTENTS_URL.'avatar/submit'?>" method="post" name="equipForm<?= $avatar['id']; ?>">
		<div class="equipment" onclick="openModal('confirm<?= $avatar['id'] ?>')">
			<input type="hidden" name="categoryCode" value="<?= $categoryCode; ?>">
			<input type="hidden" name="nowAvatar" value="<?= $equipAvatar['id']; ?>">
			<input type="hidden" name="newAvatar" value="<?= $avatar['id']; ?>">
			<input type="hidden" name="nowHp" value="<?= $equipAvatar['hitPoint']; ?>">
			<input type="hidden" name="newHp" value="<?= $avatar['hitPoint']; ?>">
			<?= Asset::img( $avatar['thumbnail'],
				array('class'=>'thumbnail', 'alt'=>'アバター')
			); ?>
			<div class="name">
				<?= $avatar['name']; ?>
			</div>
			<div class="status">
				HP+<?= $avatar['hitPoint'] ?>
			</div>
			<div class="skill">
				回避+<?= $avatar['luckPoint'] ?>
			</div>
		</div>
		
		<!-- 装備変更確認モーダル -->
		<div id="confirm<?= $avatar['id'] ?>" class="modalConfirm">
			<div class="modalRelative">
				<?= Asset::img( $equipAvatar['thumbnail'],
					array('class'=>'modalNowThumbnail', 'alt'=>'アバター')
				); ?>
				<?= Asset::img( $avatar['thumbnail'],
					array('class'=>'modalNewThumbnail', 'alt'=>'アバター')
				); ?>
				<div class="modalNowName">
					<?= $equipAvatar['name']; ?>
				</div>.
				<div class="modalNewName">
					<?= $avatar['name']; ?>
				</div>
				<div class="modalStatus">
					HP：<?= $equipAvatar['hitPoint'] ?> → <?= $avatar['hitPoint'] ?>
				</div>
				<div class="modalStatus2">
					回避：<?= $equipAvatar['luckPoint'] ?> → <?= $avatar['luckPoint'] ?>
				</div>
				<?= Asset::img( 'btn/equip.png',
					array('class'=>'modalYes', 'width'=>'27%', 'alt'=>'装備する', 'onclick'=>'document.equipForm'.$avatar['id'].'.submit()')
				); ?>
				<?= Asset::img( 'btn/leave.png',
					array('class'=>'modalNo', 'width'=>'27%', 'alt'=>'やめる', 'onclick'=>"closeModal('confirm".$avatar['id']."')")
				); ?>
			</div>
		</div>
	</form>
<?php endforeach; ?>

<!-- ページャー -->
<?php echo $pagerText; ?>

<br>
<a href="<?= CONTENTS_URL.'avatar'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>