<?php echo Asset::css('roomshop.css'); ?>
<div>
	<?= Asset::img( 'shop/furnitureTop.png',
		array(  'width'=> '100%','alt'=>'アイテム屋')
	); ?>
</div>

<div class="modalResult" id="result">
	<div class="resultRelative">
		<div class="resultText">
			<?= $roommsg ?><br>
			<?= $roommsg2 ?>
		</div>
		<?= Asset::img( 'btn/ok.png',
			array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
		); ?>
	</div>
</div>

<div>
<?php foreach((array)$roomData as $room): ?>
	<?php if($room['buyFlg'] == 1): ?>
		<?php if($status['money'] >= $room['price'] && $possession[$room['id']] == false): ?>
		<a data-target="roomConfirm<?=$room['id']?>" class="modalOpen">
			<?if(!empty($room['eventId'])):?>
				<div class="eventroom">
			<?else:?>
				<div class="room">
			<?endif;?>
		<?php else :?>
		<a>
			<div class="cannotBuy">
			<?php if($possession[$room['id']] == true) {?>
				<?= Asset::img( 'shop/soldout.png',array('class'=>'soldout', 'alt'=>'売り切れ')) ?>
			<?php }?>
		<?php endif; ?>
		
				<?= Asset::img( $room['thumbnail'],
					array('class'=>'thumbnail', 'alt'=>'部屋')
				); ?>
				<div class="name">
					<?= $room['name']; ?>
				</div>
				<div class="expo">
					<?= $room['expo']; ?>
				</div>
				<div class="apValue">
					APボーナス+<?= $room['apvalue']; ?>
				</div>
				<div class="price">
					値段&nbsp;:&nbsp;<?= $room['price'] ?>G
				</div>
			</div>
		</a>
		<div id="roomConfirm<?=$room['id']?>" class="roomConfirm">
			<div class="modal-thumbnail">
				<?= Asset::img( $room['thumbnail'],
					array('class'=>'modalThumbnail1', 'alt'=>'部屋')
				); ?>
				<?= Asset::img( 'avatar/a/ab01.png',
					array('class'=> 'a1', 'width'=> '100%', 'alt'=>'アバター')
				); ?>
				<?= Asset::img( 'avatar/body.png',
					array('class'=> 'body', 'width'=> '100%', 'alt'=>'アバター')
				); ?>
				<?= Asset::img( 'avatar/b/b01.png',
					array('class'=> 'b', 'width'=> '100%', 'alt'=>'アバター')
				); ?>
				<?= Asset::img( 'avatar/c/c01.png',
					array('class'=> 'c', 'width'=> '100%', 'alt'=>'アバター')
				); ?>
				<?= Asset::img( 'avatar/d/d01.png',
					array('class'=> 'd', 'width'=> '100%', 'alt'=>'アバター')
				); ?>
				<?= Asset::img( 'avatar/a/af01.png',
					array('class'=> 'a2', 'width'=> '100%', 'alt'=>'アバター')
				); ?>
				<?= Asset::img( 'avatar/e/e01.png',
					array('class'=> 'e', 'width'=> '100%', 'alt'=>'アバター')
				); ?>
			</div>
			<div class="nameModal">
				<?= $room['name']; ?><br>
				<p class="pstatus">
				所持G&nbsp;:&nbsp;<?= $status['money'] ?>G<br>
				↓<br>
				所持G&nbsp;:&nbsp;<?= $status['money'] - $room['price'] ?>G
				</p>
			</div>
			<form action="<?= CONTENTS_URL.'roomshop/buyresult'?>" name="buyRoom<?= $room['id'] ?>" method="post">
				<input type="hidden" name="roomId" value="<?= $room['id']; ?>">
				<?= Asset::img( 'btn/buy.png',
					array('class'=>'text', 'alt'=>'購入する', 'onclick'=>'document.buyRoom'.$room['id'].'.submit()')
				); ?>
			</form>
			<?= Asset::img( 'btn/leave.png',
				array('class'=>'modalNo', 'alt'=>'やめる', 'onclick'=>"closeModal('roomConfirm".$room['id']."')")
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