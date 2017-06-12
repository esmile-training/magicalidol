<?php echo Asset::css('compound.css'); ?>
<?php echo Asset::js('compound.js'); ?>
<div>
	<?= Asset::img( 'shop/kajiya.png',
		array(  'width'=> '100%','alt'=>'武器強化')
	); ?>
</div>
<p>選択中の武器</p>

<?php foreach($userWeapon as $weapon): ?>
	<?php if($weapon['id'] == $id ): ?>
	<form method="post" name="dataForm">
		<div class ="compound">
			<?php $baseWeapon = $weapon; ?>
			<?php $baseWeaponId = $weapon['id']; ?>
			<input type="hidden" name="id" value="<?= $baseWeaponId; ?>">
			<input type="hidden" name="weaponId" value="<?= $weapon['weaponId']; ?>">
			<input type="hidden" name="page" value="1">
			<div class="name">
				<?= $weapon['name']; ?>
			<?php if($weapon['strengthening']): ?>
				<?= "+".$weapon['strengthening']?>
			<?php endif; ?>
			<?php if($weapon['equipmentFlg']): ?>
				装備中
			<?php endif; ?>
			</div>
			<?= Asset::img( $weapon['img'],
				array('class'=>'weaponThum', 'width'=>'100%', 'alt'=>'武器')
			); ?>
			
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
	<?php endif;?>
<?php endforeach; ?>


<p>素材武器一覧</p>
<?php if(isset($pageList)):?>
	<?php foreach($pageList as $weapon): ?>
		<?php if($weapon['id'] != $id): ?>
		<form action="<?= CONTENTS_URL.'compound/submit/'.$baseWeaponId.'/'.$weapon['id'].'/'.$successRate?>" method="post" name="compoundForm<?= $weapon['id'] ;?>">
			<div class ="compound" onclick="openModal('compound<?= $weapon['id'] ?>')">
				<input type="hidden" name="baseWeaponId" value="<?= $baseWeaponId; ?>">
				<input type="hidden" name="materialWeapon" value="<?= $weapon['id']; ?>">
				
				<?= Asset::img( $weapon['img'],
					array('class'=>'weaponThum', 'width'=>'100%', 'alt'=>'武器')
				); ?>
				<div class="name">
					<?= $weapon['name']; ?>
					<?php if($weapon['strengthening']): ?>
						<?= "+".$weapon['strengthening']?>
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
						<!--モーダルの中身-->
			<div id="compound<?= $weapon['id'] ?>" class = "modalCompound">
				<div class = "modalRelative">
					<?= Asset::img( $baseWeapon['img'],
						array('class'=>'weaponThum', 'width'=>'100%', 'alt'=>'武器')
					); ?>
					<div class="modalName">
						<?= $baseWeapon['name']; ?>
						<?php if($baseWeapon['strengthening']): ?>
							<?= "+".$baseWeapon['strengthening']?>→ <?= "+".($baseWeapon['strengthening']+1) ?>
						<?php endif; ?>
					</div>
					<div class="modalAtatck">
						攻撃力+<?=$baseWeapon['status'] ?> → <?= "+".($baseWeapon['status']+1) ?>
					</div>
					<div class="modalSkill">
						スキル：<?= $baseWeapon['skillName']?><br>
					</div>
					<div class="modalDescription">
						<?= $baseWeapon['skillDescription']?>
					</div>
					<div class="modalSuccess">
						成功率：<?= $successRate?>%
					</div>
						
					<?= Asset::img( 'btn/ok.png',
						array('class'=>'modalYes', 'width'=>'30%', 'alt'=>'強化する', 'onclick'=>'document.compoundForm'.$weapon['id'].'.submit()')
					);  ?>
					<?= Asset::img( 'btn/leave.png',
						array('class'=>'modalNo', 'width'=>'30%', 'alt'=>'やめる', 'onclick'=>"closeModal('compound".$weapon['id']."')")
					);  ?>
				</div>
			</div>
		</form>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif;?>

<!-- ページャー -->
<?php if(isset($pagerText)):?>
	<?php echo $pagerText; ?>
<?endif;?>

<a href="<?= CONTENTS_URL.'compound'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>