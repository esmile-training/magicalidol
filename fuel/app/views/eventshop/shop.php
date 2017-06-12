<?php echo Asset::css('eventshop.css'); ?>

<div class="modalResult" id="result">
	<div class="resultRelative">
		<div class="resultText">
			<?= $msg ?><br>
			<?= $msg2 ?>
		</div>
		<?= Asset::img( 'btn/ok.png',
			array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
		); ?>
	</div>
</div>

<?= Asset::img( 'shop/clearinghouse_top.png',
	array('class'=>'top','width'=>'100%', 'alt'=>'画像')
); ?>

<div>
	<?= $materialName ?>×<?= $eventMaterial ?>
</div>

<?php foreach($eventshopList as $item) : ?>
	<?php if($eventMaterial >= $item['exchangeNum']): ?>
	<div class="eventItem" onclick="openModal('eventItem<?= $item['id'] ?>')">
	<?php else : ?>
	<div class="eventItemF">
	<?php endif; ?>
		<?= Asset::img( $item['thumbnail'],
			array('class'=>'itemThumbnail', 'alt'=>'画像')
		); ?>
		<div class="itemName"><?= $item['name'] ?></div>
		<div class="exchangeNum">必要数：<?= $item['exchangeNum'] ?>枚</div>
	</div>
	<div class="modalRelative">
		<div id="eventItem<?= $item['id'] ?>" class="modalConfirm">
			<?= Asset::img( $item['thumbnail'],
				array('class'=>'modalThumbnail', 'alt'=>'画像')
			); ?>
			<div class="modalName"><?= $item['name'] ?></div>
			<div class="modalMaterial">
				<?= $materialName ?><br>
				<?= $eventMaterial ?>枚⇒<?= $eventMaterial-$item['exchangeNum'] ?>枚
			</div>
			<div class="textModal">
				交換しますか？
			</div>
			<form action="<?= CONTENTS_URL.'eventshop/exchangeresult' ?>" method="post" name="exchangeForm<?= $item['id'] ?>">
				<input type="hidden" name="itemId" value="<?= $item['id'] ?>">
				<input type="hidden" name="categoryId" value="<?= $categoryId ?>">
				<input type="hidden" name="eventId" value="<?= $eventId ?>">
				<?= Asset::img( 'btn/yes.png',
					array('class'=>'yesButton', 'alt'=>'使う', 'onclick'=>'document.exchangeForm'.$item['id'].'.submit()')
				); ?>
			</form>
			<?= Asset::img( 'btn/leave.png',
				array('class'=>'noButton', 'alt'=>'やめる', 'onclick'=>"closeModal('eventItem".$item['id']."')")
			); ?>
		</div>
	</div>
<?php endforeach; ?>

<a href="<?= CONTENTS_URL.'eventshop'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>