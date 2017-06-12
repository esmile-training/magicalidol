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

<p>装備中の防具</p>

<div class="equipment">
	<?php $nowArmor = $equipArmor['id']; ?>
	<?php if($equipArmor['id']): ?>
		<?= Asset::img( $equipArmor['img'],
			array('class'=>'thumbnail', 'alt'=>'防具')
		); ?>
	<?php endif; ?>
	<div class="name">
		<?= $equipArmor['name']; ?>
	</div>
	<div class="status">
		防御力+<?= $equipArmor['status'] ?>
	</div>
</div>

<p>防具一覧</p>
<p>
	<form action="<?= CONTENTS_URL.'armor'?>" method="post" name="sortForm">
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
<?php foreach($userArmor as $armor): ?>
	<form action="<?= CONTENTS_URL.'armor/submit'?>" method="post" name="equipForm<?= $armor['id']; ?>">
		<div class="equipment" onclick="openModal('confirm<?= $armor['id'] ?>')">
			<input type="hidden" name="nowArmor" value="<?= $equipArmor['id']; ?>">
			<input type="hidden" name="newArmor" value="<?= $armor['id']; ?>">
			<?= Asset::img( $armor['img'],
				array('class'=>'thumbnail', 'alt'=>'防具')
			); ?>
			<div class="name">
				<?= $armor['name']; ?>
			</div>
			<div class="status">
				防御力+<?= $armor['status'] ?>
			</div>
		</div>
		
		<!-- 装備変更確認モーダル -->
		<div id="confirm<?= $armor['id'] ?>" class="modalConfirm">
			<div class="modalRelative">
				<?php if($equipArmor['id']): ?>
					<?= Asset::img( $equipArmor['img'],
						array('class'=>'modalNowThumbnail', 'alt'=>'防具')
					); ?>
				<?php endif; ?>
				<?= Asset::img( $armor['img'],
					array('class'=>'modalNewThumbnail', 'alt'=>'防具')
				); ?>
				<div class="modalNowName">
					<?= $equipArmor['name']; ?>
				</div>.
				<div class="modalNewName">
					<?= $armor['name']; ?>
				</div>
				<div class="modalStatus">
					防御力：<?= $equipArmor['status'] ?> → <?= $armor['status'] ?>
				</div>
				<?= Asset::img( 'btn/equip.png',
					array('class'=>'modalYes', 'width'=>'27%', 'alt'=>'装備する', 'onclick'=>'document.equipForm'.$armor['id'].'.submit()')
				); ?>
				<?= Asset::img( 'btn/leave.png',
					array('class'=>'modalNo', 'width'=>'27%', 'alt'=>'やめる', 'onclick'=>"closeModal('confirm".$armor['id']."')")
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