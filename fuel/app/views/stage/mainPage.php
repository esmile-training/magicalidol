<?php echo Asset::css('dungeon.css'); ?>
<?php echo Asset::css('dungeonSlider.css'); ?>
<?php echo Asset::js('dungeon.js'); ?>
<?php echo Asset::js('dungeonSlider.js'); ?>
<?php echo Asset::css('equipment.css'); ?>

<div class = "back">
	<div class="dungeonSlider">
		<div class="dungeonSlideSet">
			<!--前-->
			<div class="dungeonSlide">
			<?if($dungeonMap[$y-1][$x] == 0):?>
				<?= Asset::img($stageData["notpassImage"], array( 'class'=>'bgImg northImg', 'width'=>'100%')); ?>
			<?elseif($dungeonMap[$y-1][$x] == 3):?>
				<?= Asset::img($stageData["goal"], array( 'class'=>'bgImg northImg', 'width'=>'100%')); ?>
			<?elseif($dungeonMap[$y-1][$x] == 4):?>
				<?= Asset::img($stageData["passImage"], array( 'class'=>'bgImg northImg', 'width'=>'100%')); ?>
				<?= Asset::img($bossInfo['file'], array( 'class'=>'nBoss boss')); ?>
			<?else:?>
				<?= Asset::img($stageData["passImage"], array('class'=>'bgImg northImg', 'width'=>'100%')); ?>
				<?if($dungeonMap[$y-1][$x] == 2):?>
					<img class = "nStart startPos" src = "../public/assets/img/dungeonBack/start.png">
				<?endif;?>
			<?endif;?>
			<img class = "nBoss boss">
			<img class = "nStart startPos">
			</div>
			<!--右-->
			<div class="dungeonSlide">
				
			<?if($dungeonMap[$y][$x+1] == 0):?>
				<?= Asset::img($stageData["notpassImage"], array( 'class'=>'bgImg eastImg', 'width'=>'100%')); ?>
			<?elseif($dungeonMap[$y][$x+1] == 3):?>
				<?= Asset::img($stageData["goal"], array( 'class'=>'bgImg eastImg', 'width'=>'100%')); ?>
			<?elseif($dungeonMap[$y][$x+1] == 4):?>
				<?= Asset::img($stageData["passImage"], array( 'class'=>'bgImg eastImg', 'width'=>'100%')); ?>
				<?= Asset::img($bossInfo['file'], array('class'=>'eBoss boss')); ?>
				
			<?else:?>
				<?= Asset::img($stageData["passImage"], array( 'class'=>'bgImg eastImg', 'width'=>'100%')); ?>
				<?if($dungeonMap[$y][$x+1] == 2):?>
					<img class = "nStart startPos" src = "../public/assets/img/dungeonBack/start.png">
				<?endif;?>
			<?endif;?>
			<img class = "eBoss boss">
			<img class = "eStart startPos">
			</div>
			<!--後ろ-->
			<div class="dungeonSlide">
				
			<?if($dungeonMap[$y+1][$x] == 0):?>
				<?= Asset::img($stageData["notpassImage"], array( 'class'=>'bgImg southImg', 'width'=>'100%')); ?>
			<?elseif($dungeonMap[$y+1][$x] == 3):?>
				<?= Asset::img($stageData["goal"], array( 'class'=>'bgImg southImg', 'width'=>'100%')); ?>
			<?elseif($dungeonMap[$y+1][$x] == 4):?>
				<?= Asset::img($stageData["passImage"], array( 'class'=>'bgImg southImg', 'width'=>'100%')); ?>
				<?= Asset::img($bossInfo['file'], array( 'class'=>'sBoss boss')); ?>
				
			<?else:?>
				<?= Asset::img($stageData["passImage"], array( 'class'=>'bgImg southImg', 'width'=>'100%')); ?>
				<?if($dungeonMap[$y+1][$x] == 2):?>
					<img class = "nStart startPos" src = "../public/assets/img/dungeonBack/start.png">
				<?endif;?>
				
			<?endif;?>
			<img class = "sBoss boss">
			<img class = "sStart startPos">

			</div>
			<!--左-->
			<div class="dungeonSlide">
			
			<?if($dungeonMap[$y][$x-1] == 0):?>
				<?= Asset::img($stageData["notpassImage"], array( 'class'=>'bgImg westImg', 'width'=>'100%')); ?>
			<?elseif($dungeonMap[$y][$x-1] == 3):?>
				<?= Asset::img($stageData["goal"], array( 'class'=>'bgImg westImg', 'width'=>'100%')); ?>
			<?elseif($dungeonMap[$y][$x-1] == 4):?>
				<?= Asset::img($stageData["passImage"], array( 'class'=>'bgImg westImg', 'width'=>'100%')); ?>
				<?= Asset::img($bossInfo['file'], array( 'class'=>'wBoss boss')); ?>
				
			<?else:?>
				<?= Asset::img($stageData["passImage"], array( 'class'=>'bgImg westImg', 'width'=>'100%')); ?>
				<?if($dungeonMap[$y][$x-1] == 2):?>
					<img class = "nStart startPos" src = "../public/assets/img/dungeonBack/start.png">
				<?endif;?>
			<?endif;?>
			<img class = "wBoss boss">
			<img class = "wStart startPos">
			</div>

				
		</div>

	</div>
	<div class="expansionFrame">
			<img class = "goalEfect">
			<img class = "expansion">
	</div>
	<div class="tutorialWord tutorialTouch" onclick="tutorialAnimation()">
		Touch
	</div>
	<div class="tutorialWord tutorialSlide1" onclick="tutorialAnimation()">
		Slide
	</div>
	<div class="tutorialWord tutorialSlide2" onclick="tutorialAnimation()">
		Slide
	</div>
	<div class="tutorialOverlay"></div>
	
	<div class="loadBg"></div>
</div>

<div class="log">
	<div class="avatarThumnail">
		<?php for($cnt=0; $cnt<count($avatarImg); $cnt++): ?>
			<?= Asset::img( $avatarImg[$cnt],
				array('class'=>'avatarImg', 'alt'=>'アバター')
			); ?>
		<?php endfor; ?>
	</div>
	<div class="stageLog">
		<div class="logText" id="stageLog"><?= $log ?></div>
	</div>
</div>
<form action="<?//= CONTENTS_URL.'stage/mainpage/'?>" method="post" name="dungeonForm">
	<input type="hidden" name="x" value="<?= $x;?>">
	<input type="hidden" name="y" value="<?= $y;?>">
	<input type="hidden" name="direction" value="<?= $direction;?>">
	<input type="hidden" name="north" value="<?= $dungeonMap[$y-1][$x];?>">
	<input type="hidden" name="east" value="<?= $dungeonMap[$y][$x+1];?>">
	<input type="hidden" name="south" value="<?= $dungeonMap[$y+1][$x];?>">
	<input type="hidden" name="west" value="<?= $dungeonMap[$y][$x-1];?>">
	<input type="hidden" name="userId" value="<?= $userId;?>">
	<input type="hidden" name="mapEvent" value="<?= $mapEvent;?>">
	<input type="hidden" name="ap" value="<?= $ap;?>">
</form>
<form action="<?= CONTENTS_URL.'stage/submit'?>" method="post" name="clearForm">
</form>
<form action="<?= CONTENTS_URL.'stage/battle'?>" method="post" name="battleForm">
	<input type="hidden" name="bossFlg" value=0>
</form>
<form action="<?= CONTENTS_URL.'equipment'?>" method="post" name="equipForm">
	<input type="hidden" name="dungeon" value=1>
</form>
<!--ログ-->
<div class = "command">
	<div class = "compass">
		<?= Asset::img( 'etc/compass_01.png',
			array('class'=>'compassBase')
		); ?>
		<?= Asset::img( 'etc/compass_02.png',
			array('class'=>'compassPointer')
		); ?>
		<?= Asset::img( 'etc/compass_03.png',
			array('class'=>'compassFrame')
		); ?>
	</div>
	<div class="commandBtn commandItem" onclick="openModal('itemList')"></div>
	<div class="commandBtn commandWeapon"  onclick="document.equipForm.submit();"></div>
</div>

<!--モーダル-->
<div class = "modalContent" id = "item">
		<div class="resultRelative">
			<div class="resultText">
				アイテムを入手しました。
			</div>
			<?= Asset::img( 'btn/ok.png',
				array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('item')")
			); ?>
		</div>
</div>
<div class = "modalContent" id = "wall">
		<div class="resultRelative">
			<div class="resultText">
				壁です。前に進めません。
			</div>
			<?= Asset::img( 'btn/ok.png',
				array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('wall')")
			); ?>
		</div>
</div>

<div class="modalItem" id="itemList">
	<div class="itemTitle">所持アイテム</div>
	<div class="itemTypeBtn recoverItemBtn" onclick="displayItemRecover()"></div>
	<div class="itemTypeBtn apItemBtn" onclick="displayItemApRecover()"></div>
	<div class="itemList">
		<?php foreach($itemList['recover'] as $item): ?>
			<div class="itemData itemRecover" id="recover<?= $item['itemId'] ?>">
				<?= Asset::img( $item['img'],
					array('class'=>'itemImg', 'alt'=>'アイテム画像')
				); ?>
				<div class="itemText">
					<div class="itemName"><?= $item['name'] ?></div>
					<div class="itemCount">所持数：<span id="recover<?= $item['itemId'] ?>count"><?= $item['count'] ?></span>個</div>
					<div class="itemDescription">効果：<?= $item['description'] ?></div>
					<?= Asset::img( 'btn/use.png',
						array('class'=>'itemUseBtn generalBtn', 'alt'=>'使う', 'onclick'=>"useItem(".$item['value'].",1, ".$item['itemId'].")")
					); ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php foreach($itemList['ap'] as $item): ?>
			<div class="itemData itemAp" id="ap<?= $item['itemId'] ?>">
				<?= Asset::img( $item['img'],
					array('class'=>'itemImg', 'alt'=>'アイテム画像')
				); ?>
				<div class="itemText">
					<div class="itemName"><?= $item['name'] ?></div>
					<div class="itemCount">所持数：<span id="ap<?= $item['itemId'] ?>count"><?= $item['count'] ?></span>個</div>
					<div class="itemDescription">効果：<?= $item['description'] ?></div>
					<?= Asset::img( 'btn/use.png',
						array('class'=>'itemUseBtn generalBtn', 'alt'=>'使う', 'onclick'=>"useItem(".$item['value'].",2, ".$item['itemId'].")")
					); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?= Asset::img( 'btn/leave.png',
		array('class'=>'modalCloseBtn generalBtn', 'alt'=>'やめる', 'onclick'=>"closeModal('itemList')")
	); ?>
</div>