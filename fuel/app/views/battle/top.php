<?php echo Asset::js('battle.js'); ?>
<?php echo Asset::css('battle.css'); ?>

<div class="battleImg">
	<?= Asset::img( $bgImg,
		array('class'=>'bgImg', 'width'=>'100%', 'alt'=>'背景')
	); ?>
	<?= Asset::img( $enemyImg,
		array('class'=>'enemyImg', 'width'=>'100%', 'alt'=>'敵画像')
	); ?>
	<div class="hpGaugeBattle">
		<div class="hpGaugeBar">
			<?= Asset::img( 'battle/hpgauge_02.png',
				array('class'=>'hpGaugeBarImg', 'alt'=>'HPゲージ')
			); ?>
		</div>
		<?= Asset::img( 'battle/hpgauge_03.png',
			array('class'=>'hpGaugeFrame', 'alt'=>'HPゲージ')
		); ?>
	</div>
	<div class="userHp">HP <div class="hpArea"><span id="hp"><?= $hpNow ?></span> / <span id="hpMax"><?= $hpMax ?></span></div></div>
	<div class="buffArea">
		<?php if(!is_null($useItem)): ?>
			<div class="buffIcon itemBuff">
				<?= Asset::img( $useItem['buffImg'],
					array('class'=>'buffImg', 'alt'=>'バフ画像')
				); ?>
				<div class="buffText">×<?= $useItem['value'] ?></div>
			</div>
		<?php endif; ?>
		<?php if(!is_null($skillBuff)): ?>
			<div class="buffIcon skillBuff">
				<?= Asset::img( $skillBuff['buffImg'],
					array('class'=>'buffImg', 'alt'=>'バフ画像')
				); ?>
				<div class="buffText">×<?= $skillBuff['value'] ?></div>
			</div>
		<?php endif; ?>
	</div>
	<div class="enemyDamageEffect"></div>
	<div class="userDamageEffect"></div>
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
	<div class="battleLog">
		<div class="logText" id="battleLog"><?= $log ?></div>
	</div>
</div>

<div class="battleCommand">
	<?= Asset::img( 'etc/cheer.png',
		array('class'=>'cheerCommand', 'width'=>'40%', 'alt'=>'応援コマンド')
	); ?>
	<div class="cheerBtn cheerAttack" class onclick="submitBattle(1, 1)"></div>
	<div class="cheerBtn cheerDiffence" onclick="submitBattle(1, 2)"></div>
	<div class="cheerBtn cheerAvoid" onclick="submitBattle(1, 3)"></div>
	<div class="commandBtn commandSkill" onclick="submitBattle(2)"></div>
	<div class="commandBtn commandItem" onclick="openModal('itemList')"></div>
</div>
<div class="commandOverlay"></div>

<div class="modalItem" id="itemList">
	<div class="itemTitle">所持アイテム</div>
	<div class="itemTypeBtn recoverItemBtn" onclick="displayItemRecover()"></div>
	<div class="itemTypeBtn battleItemBtn" onclick="displayItemBattle()"></div>
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
						array('class'=>'itemUseBtn generalBtn', 'alt'=>'使う', 'onclick'=>"submitBattle(3, ".$item['category'].", ".$item['itemId'].")")
					); ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php foreach($itemList['battle'] as $item): ?>
			<div class="itemData itemBattle" id="battle<?= $item['itemId'] ?>">
				<?= Asset::img( $item['img'],
					array('class'=>'itemImg', 'alt'=>'アイテム画像')
				); ?>
				<div class="itemText">
					<div class="itemName"><?= $item['name'] ?></div>
					<div class="itemCount">所持数：<span id="battle<?= $item['itemId'] ?>count"><?= $item['count'] ?></span>個</div>
					<div class="itemDescription">効果：<?= $item['description'] ?></div>
					<?= Asset::img( 'btn/use.png',
						array('class'=>'itemUseBtn generalBtn', 'alt'=>'使う', 'onclick'=>"submitBattle(3, ".$item['category'].", ".$item['itemId'].")")
					); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?= Asset::img( 'btn/leave.png',
		array('class'=>'modalCloseBtn generalBtn', 'alt'=>'やめる', 'onclick'=>"closeModal('itemList')")
	); ?>
</div>

<form name="config">
	<input type="hidden" name="battleSpeed" value="<?= $battleSpeed ?>">
</form>