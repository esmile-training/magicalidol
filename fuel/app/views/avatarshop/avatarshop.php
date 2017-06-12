<?php echo Asset::css('avatarshop.css'); ?>
<?php echo Asset::css('modal.css'); ?><!--ここから-->
<?php echo Asset::js('jquery.js'); ?>
<?php echo Asset::js('modal.js'); ?><!--ここまで追加-->
<?php echo Asset::js('avatarshop.js'); ?>
<div>
	<?= Asset::img( 'shop/hukuyaTop.png',
		array(  'width'=> '100%','alt'=>'服屋')
	); ?>
</div>

<div class="modalResult" id="result">
	<div class="resultRelative">
		<div class="resultText">
			<?= $avatarmsg ?><br>
			<?= $avatarmsg2 ?>
		</div>
		<?= Asset::img( 'btn/ok.png',
			array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
		); ?>
	</div>
</div>

<?php foreach($avatarData['dataList'] as $avatar): ?>
<?php if($avatar['buyFlg'] == 1) : ?>
	<?php if($status['money'] >= $avatar['price'] && $canBuyAvatar[$avatar['id']] == false)
	{?>
	<a data-target="avatarConfirm<?= $avatar['id'] ?>" class="modalOpen">
		<?if(!empty($avatar['eventId'])):?>
			<div class="eventavatar">
		<?else:?>
			<div class="avatar">
		<?endif;?>
	<?php }else {?>	
	<a>
		<div class="cannotBuy">
		<?php if($canBuyAvatar[$avatar['id']] == true) {?>
			<?= Asset::img( 'shop/soldout.png',array('class'=>'soldout', 'alt'=>'売り切れ')) ?>
		<?php }?>
	<?php } ?>
			<?= Asset::img( $avatar['thumbnail'],
				array('class'=>'thumbnail', 'alt'=>'アバター')
			); ?>
			<div class="name">
				<?= $avatar['name']; ?>
			</div>
			<div class="status">
				HP+<?= $avatar['hitPoint'] ?>&nbsp;&nbsp;
				回避+<?= $avatar['luckPoint'] ?>
			</div>
			<div class="price">
				値段&nbsp;:&nbsp;<?= $avatar['price'] ?>G
			</div>
		</div>
	</a>
	<div id="avatarConfirm<?= $avatar['id'] ?>" class="avatarConfirm">
		<div class="modal-thumbnail">
			<?= Asset::img( $avatar['thumbnail'],
				array('class'=>'modalThumbnail', 'alt'=>'アバター','width'=>'100%')
			); ?>
		</div>
		<div class="nameModal">
			<?= $avatar['name']; ?><br>
			<p class="pstatus">
			所持G&nbsp;:&nbsp;<?= $status['money'] ?>G<br>
			↓<br>
			所持G&nbsp;:&nbsp;<?= $status['money'] - $avatar['price'] ?>G
			</p>
		</div>
		<a href="<?= CONTENTS_URL.'avatarshop/buyresult/'.$categoryCode.'/'.$avatar['id'] ?>">
			<?= Asset::img( 'btn/buy.png',
				array('class'=>'text', 'alt'=>'購入する')
			); ?>
		</a>
	<?= Asset::img( 'btn/leave.png',
		array('class'=>'modalNo', 'alt'=>'やめる', 'onclick'=>"closeModal('avatarConfirm".$avatar['id']."')")
	); ?>
	</div>
<?php endif; ?>
<?php endforeach; ?>
</div>
<form action="<?= CONTENTS_URL.'avatarshop/index/'.$categoryCode ?>" name="pageForm" method="post">
<input type="hidden" name="page" value="1">
</form>
<!-- ページャー -->
<?php echo $pagerText; ?>

<a href="<?= CONTENTS_URL.'avatarshop/select'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>

<?//php var_dump($debugData) ?>