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

<p>装備中の武器</p>

<div class="equipment">
	<?php $nowWeapon = $equipWeapon['id']; ?>
	<?php if($equipWeapon['id']): ?>
		<?= Asset::img( $equipWeapon['img'],
			array('class'=>'thumbnail', 'alt'=>'武器')
		); ?>
	<?php endif; ?>
	<div class="name">
		<?= $equipWeapon['name']; ?>
		<?php if($equipWeapon['strengthening']): ?>
			<?= "+".$equipWeapon['strengthening']?>
		<?php endif; ?>
	</div>
	<div class="status">
		攻撃力+<?= $equipWeapon['status'] ?>
	</div>
	<div class="skill">
		スキル：<?= $equipWeapon['skillName']?>
	</div>
	<div class="description">
		<?= $equipWeapon['skillDescription']?>
	</div>
</div>

<p>装備一覧</p>
<p>
	<form action="<?= CONTENTS_URL.'weapon'?>" method="post" name="sortForm">
		<input type="hidden" name="page" value="1">
		<select name="sort" onchange="document.sortForm.submit()">
		<?php foreach((array)$sortType as $id=>$value): ?>
			<?php if($id == $sort): ?>
				<option value="<?= $id; ?>" selected><?= $value; ?></option>
			<?php else: ?>
				<option value="<?= $id; ?>"><?= $value; ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
		</select>
		<select name="category" onchange="document.sortForm.submit()">
		<?php foreach((array)$categoryList as $id=>$value): ?>
			<?php if($id == $category): ?>
				<option value="<?= $id; ?>" selected><?= $value; ?></option>
			<?php else: ?>
				<option value="<?= $id; ?>"><?= $value; ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
		</select>
	</form>
</p>

<?php foreach((array)$userWeapon as $weapon): ?>
	<form action="<?= CONTENTS_URL.'weapon/submit'?>" method="post" name="equipForm<?= $weapon['id']; ?>">
		<div class="equipment" onclick="openModal('confirm<?= $weapon['id'] ?>')">
			<input type="hidden" name="nowWeapon" value="<?= $nowWeapon; ?>">
			<input type="hidden" name="newWeapon" value="<?= $weapon['id']; ?>">
			<?= Asset::img( $weapon['img'],
				array('class'=>'thumbnail', 'alt'=>'武器')
			); ?>
			<div class="name">
			<?= $weapon['name']; ?>
			<?php if($weapon['strengthening']): ?>
				<?= "+".$weapon['strengthening']?>
			<?php endif; ?>
			</div>
			<div class="status">
				攻撃力+<?= $weapon['status'] ?>
			</div>
			<div class="skill">
				スキル：<?= $weapon['skillName']?>
			</div>
			<div class="description">
				<?= $weapon['skillDescription']?>
			</div>
		</div>
		
		<!-- 装備変更確認モーダル -->
		<div id="confirm<?= $weapon['id'] ?>" class="modalConfirm">
			<div class="modalRelative">
				<?php if($equipWeapon['id']): ?>
					<?= Asset::img( $equipWeapon['img'],
						array('class'=>'modalNowThumbnail', 'alt'=>'武器')
					); ?>
				<?php endif;?>
				<?= Asset::img( $weapon['img'],
					array('class'=>'modalNewThumbnail', 'alt'=>'武器')
				); ?>
				<div class="modalNowName">
					<?= $equipWeapon['name']; ?>
					<?php if($equipWeapon['strengthening']): ?>
						<?= "+".$equipWeapon['strengthening']?>
					<?php endif; ?>
				</div>.
				<div class="modalNewName">
					<?= $weapon['name']; ?>
					<?php if($weapon['strengthening']): ?>
						<?= "+".$weapon['strengthening']?>
					<?php endif; ?>
				</div>
				<div class="modalStatus">
					攻撃力：<?= $equipWeapon['status'] ?> → <?= $weapon['status'] ?>
				</div>
				<div class="modalStatus2">
					スキル：<?= $equipWeapon['skillName']?> → <?= $weapon['skillName']?>
				</div>
				<?= Asset::img( 'btn/equip.png',
					array('class'=>'modalYes', 'width'=>'27%', 'alt'=>'装備する', 'onclick'=>'document.equipForm'.$weapon['id'].'.submit()')
				); ?>
				<?= Asset::img( 'btn/leave.png',
					array('class'=>'modalNo', 'width'=>'27%', 'alt'=>'やめる', 'onclick'=>"closeModal('confirm".$weapon['id']."')")
				); ?>
			</div>
		</div>
	</form>
<?php endforeach; ?>

<!-- ページャー -->
<?php echo $pagerText; ?>

<br>
<a href="<?= CONTENTS_URL.'equipment'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>
