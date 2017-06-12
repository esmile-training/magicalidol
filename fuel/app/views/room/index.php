<?php echo Asset::css('room.css'); ?>

<?php if(isset($roommsg)): ?>
	<div class="modalSuccess" id="result">
		<div class="successRelative">
			<div class="successText">
				<?= $roommsg ?>
			</div>
			<?= Asset::img( 'btn/ok.png',
				array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
			); ?>
		</div>
	</div>
<?php endif; ?>

<p>現在の部屋</p>
<div class="nowRoom">
	<?= Asset::img( $nowRoom['thumbnail'],
		array('class'=>'thumbnail', 'alt'=>'現在部屋')
	); ?>
	<div class="name">
		<?= $nowRoom['name'] ?>
	</div>
	<div class="expo">
		<?= $nowRoom['expo'] ?>
	</div>
</div>


<p>所持部屋一覧</p>

<?php foreach((array)$otherRooms as $room): ?>
	<div class="otherRoom" onclick="openModal('otherRoom<?= $room['id'] ?>')">
		<?= Asset::img( $room['thumbnail'],
			array('class'=>'thumbnail', 'alt'=>'所持部屋')
		); ?>
		<div class="name">
			<?= $room['name'] ?>
		</div>
		<div class="expo">
			<?= $room['expo'] ?>
		</div>
		<div class="apValue">
			APボーナス+<?= $room['apvalue'] ?>
		</div>
	</div>
	<div id="otherRoom<?= $room['id'] ?>" class="modalConfirm">
		<div class="modalRelative">
			<form action="<?= CONTENTS_URL.'room/change' ?>" name="roomForm<?= $room['id'] ?>" method="post">
			<input type="hidden" name="nowRoomId" value="<?= $nowRoom['roomId'] ?>">
			<input type="hidden" name="newRoomId" value="<?= $room['roomId'] ?>">
				<?= Asset::img( $nowRoom['thumbnail'],
					array('class'=>'modalThumbnail1', 'alt'=>'現在部屋')
				); ?>
				<div class="modalMark">
					→
				</div>
				<?= Asset::img( $room['thumbnail'],
					array('class'=>'modalThumbnail2', 'alt'=>'所持部屋')
				); ?>
				<div class="modalName">
					<p class="pNowRoom">
						<?= $nowRoom['name'] ?>
					</p>
					<p class="pNewRoom">
						<?= $room['name'] ?>
					</p><br>
					<p class="confirmText">
						模様替えしますか？
					</p>
				</div>
				<?= Asset::img( 'btn/yes.png',
					array('class'=>'modalYes', 'width'=>'27%', 'alt'=>'模様替えする', 'onclick'=>'document.roomForm'.$room['id'].'.submit()')
				); ?>
				<?= Asset::img( 'btn/no.png',
					array('class'=>'modalNo', 'width'=>'27%', 'alt'=>'やめる', 'onclick'=>"closeModal('otherRoom".$room['id']."')")
				); ?>
			</form>
		</div>
	</div>
<?php endforeach; ?>

<br>
<a href="<?= CONTENTS_URL.'equipment'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>
