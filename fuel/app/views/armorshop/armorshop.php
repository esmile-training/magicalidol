<?php echo Asset::css('armorshop.css'); ?>
<div>
	<?= Asset::img( 'shop/bouguTop.png',
		array(  'width'=> '100%','alt'=>'武器ガチャ')
	); ?>
</div>

<div class="modalResult" id="result">
	<div class="resultRelative">
		<div class="resultText">
			<?= $armormsg ?><br>
			<?= $armormsg2 ?>
		</div>
		<?= Asset::img( 'btn/ok.png',
			array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
		); ?>
	</div>
</div>

<div>
<?php foreach($armorData as $key=>$armor): ?>
	<?php if($armor['id'] != 1): ?>
		<?php if($status['money'] >= $armor['price'] && $possession[$key] == false && $enoughMaterial[$key] == true)
		{
			echo '<a data-target="armorConfirm'.$armor['id'].'" class="modalOpen">';
			echo '<div class="armor">';
		} 
		else 
		{
			echo '<a>';
			echo '<div class="cannotBuy">';
			if($possession[$key] == true)
			{
		?>
				<?= Asset::img( 'shop/soldout.png',array('class'=>'soldout', 'alt'=>'売り切れ')) ?>
		<?php	}
		}?>
			<?= Asset::img( $armor['img'],
				array('class'=>'thumbnail', 'alt'=>'防具')
			); ?>
			<div class="name">
				<?= $armor['name']; ?>
			</div>
			<div class="status">
				防御力 : +<?= $armor['status'] ?><br>
			</div>
			<table class="needMaterial">
				<tr class="index">
					<td class="datacenter">必要素材</td>
					<td class="datacenter">所持数</td>
					<td class="datacenter">必要数</td>
				</tr>
				<?php foreach($armorMaterial[$key] as $id=>$armorMaterialNum): ?>
				<tr>
					<td class="datacenter"><?= $materialData[$id]['name'] ?></td>
					<td class="dataright"><?= $userMaterial[$id] ?></td>
					<td class="dataright"><?= $armorMaterialNum ?></td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td>ゴールド</td>
					<td class="dataright"><?= $status['money'] ?>G</td>
					<td class="dataright"><?= $armor['price'] ?>G</td>
				</tr>
			</table>
			<!--div class="price">
				price : <?//= $armor['price'] ?>G<br>
			</div-->
		</div>
	</a>
	<div id="armorConfirm<?= $armor['id'] ?>" class="armorConfirm">
		<div class="modal-thumbnail">
			<?= Asset::img( $armor['img'],
				array('class'=>'modalThumbnail', 'alt'=>'防具')
			); ?>
		</div>
		<div class="nameModal">
			<?= $armor['name']; ?><br>
			<div class="materialModal">
				<?php foreach($armorMaterial[$key] as $id=>$armorm): ?>
					<?= $materialData[$id]['name'] ?> : <?= $userMaterial[$id] ?>&nbsp;⇒&nbsp; <?= $userMaterial[$id]-$armorm ?><br>
				<?php endforeach; ?>
			</div>
			<p class="pstatus">
			所持G&nbsp;:<?= $status['money'] ?>G&nbsp;=>&nbsp;<?= $status['money'] - $armor['price'] ?>G
			</p>
		</div>
		<a href="<?= CONTENTS_URL.'armorshop/buyresult/'.$armor['id'] ?>">
			<?= Asset::img( 'btn/buy.png',
				array('class'=>'text', 'alt'=>'購入する')
			); ?>
		</a>
		<?= Asset::img( 'btn/leave.png',
			array('class'=>'modalNo', 'alt'=>'やめる', 'onclick'=>"closeModal('armorConfirm".$armor['id']."')")
		); ?>
	</div>
	<?php endif; ?>
<?php endforeach; ?>
</div>


<a href="<?= CONTENTS_URL.'shop'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>