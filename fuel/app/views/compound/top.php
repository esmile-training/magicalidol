<?php echo Asset::css('compound.css'); ?>
<?php echo Asset::js('compound.js'); ?>

<?if(isset($msg)):?>
	<!--モーダルの中身-->
	<div class="modalResult" id="result">
		<div class="resultRelative">
			<div class="resultText">
				<?= $msg;?>
			</div>
			<?= Asset::img( 'btn/ok.png',
				array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
			); ?>
		</div>
	</div>
<?endif;?>
<div>
	<?= Asset::img( 'shop/kajiya.png',
		array(  'width'=> '100%','alt'=>'武器強化')
	); ?>
</div>

<?php if(!empty($eventCompoundData)): ?>
	<div class="eventCompound">
		<?= Asset::img($eventCompoundData['compoundImg'],
		array('width' => '100%', 'top' => '10.5%','position' => 'absolut',
		'left' => '0%')); ?>
	</div>
<?php endif; ?>

<p>装備中の武器</p>
<form action="<?= CONTENTS_URL.'compound/select'?>" method="post" name="compoundForm<?= $equipWeapon['id']; ?>">
	<div class = "compound" onclick="document.compoundForm<?= $equipWeapon['id']; ?>.submit()">
		<input type="hidden" name="id" value="<?= $equipWeapon['id']; ?>">
		<input type="hidden" name="weaponId" value="<?= $equipWeapon['weaponId']; ?>">
		<input type="hidden" name="category" value="<?= $equipWeapon['category']; ?>">
		<?php $nowWeapon = $equipWeapon['id']; ?>
		<?php if($equipWeapon): ?>
			<?= Asset::img( $equipWeapon['img'],
				array('class'=>'weaponThum', 'width'=>'100%', 'alt'=>'武器')
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
</form>

<p>武器一覧</p>
<p>
	<form action="<?= CONTENTS_URL.'compound'?>" method="post" name="dataForm">
		<input type="hidden" name="page" value="1">
		<select name="category" onchange="document.dataForm.submit()">
		<?php foreach($categoryList as $id=>$value): ?>
			<?php if($id == $category): ?>
				<option value="<?= $id; ?>" selected><?= $value; ?></option>
			<?php else: ?>
				<option value="<?= $id; ?>"><?= $value; ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
		</select>
	</form>
</p>
<?if(isset($userWeapon)):?>
	<?php foreach($userWeapon as $weapon): ?>
		<form action="<?= CONTENTS_URL.'compound/select'?>" method="post" name="compoundForm<?= $weapon['id']; ?>">
			<div class ="compound" onclick="document.compoundForm<?= $weapon['id']; ?>.submit()">
				<input type="hidden" name="id" value="<?= $weapon['id']; ?>">
				<input type="hidden" name="weaponId" value="<?= $weapon['weaponId']; ?>">
				<input type="hidden" name="category" value="<?= $weapon['category']; ?>">
				
				<?= Asset::img( $weapon['img'],
					array('class'=>'weaponThum', 'width'=>'100%', 'alt'=>'武器')
				); ?>
				<div class="name">
					<?= $weapon['name']; ?>
					<?php if($weapon['strengthening']): ?>
						<?= "+".$weapon['strengthening']?>
					<?php endif; ?>
					<?php if($weapon['equipmentFlg']): ?>
						装備中
					<?php endif; ?>
				</div>
				<div class="atatck">
					攻撃力+<?= $weapon['status'] ?>
				</div>
				<div class="skill">
					スキル：<?= $weapon['skillName']?>
				</div>
				<div class="description">
					<?= $weapon['skillDescription']?>
				</div>
			</div>
		</form>
	<?php endforeach; ?>
<?endif;?>
<!-- ページャー -->
<?php if(isset($pagerText)):?>
	<?php echo $pagerText; ?>
<?endif;?>

<a href="<?= CONTENTS_URL.'mypage'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>