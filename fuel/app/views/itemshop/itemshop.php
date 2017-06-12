<?php echo Asset::css('itemshop.css'); ?>
<?php echo Asset::js('itemshop.js'); ?>
<div>
	<?= Asset::img( 'shop/aitemuya_Top.png',
		array(  'width'=> '100%','alt'=>'アイテム屋')
	); ?>
</div>

<div class="modalResult" id="result">
	<div class="resultRelative">
		<div class="resultText">
			<?= $itemmsg ?><br>
	<?= $itemmsg2 ?>
		</div>
		<?= Asset::img( 'btn/ok.png',
			array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
		); ?>
	</div>
</div>

<div class="menuBox">
	<div>
		<div class="box">
			<a  href="<?= CONTENTS_URL.'itemshop/select/1'?>">
				<div class="hp"></div>
			</a>
		</div>
		<div class="box">
			<a  href="<?= CONTENTS_URL.'itemshop/select/2'?>">
				<div class="ap"></div>
			</a>			
		</div>
		<div class="box">
			<a  href="<?= CONTENTS_URL.'itemshop/select/3'?>">
				<div class="support"></div>
			</a>			
		</div>		
	</div>
</div>
<div>
<?php foreach((array)$itemData as $key=>$item): ?>
	<?php if($item['price'] <= $status['money']){ ?>
		<a data-target="itemConfirm<?= $item['id'] ?>" class="modalOpen">
			<div class="item">
	<?php } else { ?>
		<a>
			<div class="cannotBuy">
	<?php } ?>
				<?= Asset::img( $item['img'],
					array('class'=>'thumbnail', 'alt'=>'アイテム')
				); ?>
				<div class="name">
					<?= $item['name'] ?>
				</div>
				<div class="status">
					<?= $item['description'] ?>
				</div>
				<div class="price">
					値段&nbsp;:&nbsp;<?= $item['price'] ?>G
				</div>
			</div>
		</a>
		<div id="itemConfirm<?= $item['id'] ?>" class="itemConfirm">
			<div class="modal-thumbnail">
				<?= Asset::img( $item['img'],
					array('class'=>'modalThumbnail', 'alt'=>'アイテム')
				); ?>
			</div>
			<form action="<?=CONTENTS_URL?>itemshop/buyresult" method="post" name="buyButton<?= $item['id'] ?>">
				<input type="hidden" name="itemType" value="<?= $itemType ?>">
				<input type="hidden" name="itemId" value="<?= $item['id'] ?>">
				<div class="nameModal">
					<?= $item['name'] ?>
				</div>
				<div class="selectNum">
					<select id="itemNum<?= $item['id'] ?>" name="itemNum" class="itemSelect" onchange="changePrice(<?= $item['price']?>, <?= $item['id'] ?>, <?= $status['money'] ?>)">
						<?php for($i = 1;$i <= $maxCount[$item['id']-1];$i++): ?>
							<option value="<?= $i ?>"><?= $i ?></option>
						<?php endfor; ?>
					</select>個 <br>
				</div>
				<div class="totalGold">
					合計:<span id="buyPrice<?= $item['id'] ?>"><?= $item['price']?></span>G
				</div>
				<div class="showResult">
					所持金<br>
					<?= $status['money'] ?>G&nbsp;=>&nbsp;<span id="buyResult<?= $item['id'] ?>"><?= $status['money']-$item['price']?></span>G
				</div>
				<?= Asset::img( 'btn/buy.png',
					array('class'=>'text', 'alt'=>'購入する','onclick'=>'document.buyButton'.$item['id'].'.submit()')
				); ?>
				<?= Asset::img( 'btn/leave.png',
					array('class'=>'modalNo', 'alt'=>'やめる', 'onclick'=>"closeModal('itemConfirm".$item['id']."')")
				); ?>
			</form>
		</div>
<?php endforeach; ?>
</div>

<a href="<?= CONTENTS_URL.'shop'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>