<?php echo Asset::css('weaponGacha.css'); ?>
<div>
	<?= Asset::img( 'shop/weapon_gacha_top.png',
		array(  'width'=> '100%','alt'=>'武器ガチャ')
	); ?>
</div>
<?php if(!empty($eventGachaData)): ?>
	<div class = "eventImgGacha">
		<?= Asset::img($eventGachaData['eventImg']); ?>
	</div>
<?php endif; ?>

<div class="modalContent" id="result">
	<div class="resultRelative">
		<div class="resultText">
			<?= $gachamsg ?><br>
			<?= $gachamsg2 ?>
		</div>
		<?= Asset::img( 'btn/ok.png',
			array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
		); ?>
	</div>
</div>

<div>
	<?php foreach($materialData as $material) : ?>
		<div class="oneGacha">
		<?php	if($canGacha[$material['id']] == true)
			{
		?>
				<div class="canGacha" onclick = "openModal('gachaConfirm<?= $material['id'] ?>')">
		<?php 
			}
			else
			{
		?>
				<div class="cannotGacha">
		<?php
			}
		?>
			
			<div class="name">
				<?= $material['name'] ?>の素材ガチャ
			</div>
			<div class="status">
				<table class="tableSize">
				<tr class="index">
					<td class="datacenter">必要素材</td>
					<td class="datacenter">所持数</td>
					<td class="datacenter">必要数</td>
				</tr>
				<?php foreach($weaponGachaData[$material['id']]['material'] as $id=>$weaponGachaNum): ?>
				<tr>
					<td class="datacenter"><?= $materialData[$id]['name'] ?></td>
					<td class="dataright"><?= $userMaterialNum[$id] ?></td>
					<td class="dataright"><?= $weaponGachaNum ?></td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td>ゴールド</td>
					<td class="dataright"><?= $userData['money'] ?>G</td>
					<td class="dataright"><?= $weaponGachaData[$material['id']]['gold'] ?>G</td>
				</tr>
			</table>
			</div>
		</div>
		</div>
		<div id="gachaConfirm<?= $material['id'] ?>" class="gachaConfirm">
			<div class="nameConfirm">
				<?= $material['name'] ?>の素材ガチャ<br>
				<p class="pstatus">
				素材を使用して武器を生成します<br><br>
				所持ゴールド : <?= $userData['money'] ?>G&nbsp; ⇒ &nbsp;<?= $userData['money']-$weaponGachaData[$material['id']]['gold'] ?>G<br>
				<?php foreach($weaponGachaData[$material['id']]['material'] as $id=>$weaponGacha): ?>
					<?= $materialData[$id]['name'] ?>&nbsp;&nbsp;&nbsp; : <?= $userMaterialNum[$id] ?>&nbsp; ⇒&nbsp; <?= $userMaterialNum[$id]-$weaponGacha ?><br>
				<?php endforeach; ?>
				</p>
			</div>
			<a href="<?= CONTENTS_URL.'weapongacha/gacharesult/'.$material['id'] ?> ">
				<?= Asset::img( 'btn/synthesis.png',
					array('class'=>'text','alt'=>'購入する')
				); ?>
			</a>
			<?= Asset::img( 'btn/leave.png',
				array('class'=>'modalNo', 'alt'=>'やめる', 'onclick'=>"closeModal('gachaConfirm".$material['id']."')")
			); ?>
		</div>
	<?php endforeach; ?>
</div>

<a href="<?= CONTENTS_URL.'shop'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>