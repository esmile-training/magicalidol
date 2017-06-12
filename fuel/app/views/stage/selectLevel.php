<?php echo Asset::css('selectstage.css'); ?>
<?php echo Asset::js('modalStage.js'); ?>

<?php if(isset($dungeonFlag) && $dungeonFlag): ?>
<div class="modalResult" id="result">
	<div class="resultRelative">
		<div class="resultText">
		中断したダンジョンを再開しますか？
		</div>
		<div class="resultText2">
		(いいえを押した場合、中断したダンジョンは破棄されます)
		</div>
		<form name="yesButton" method="post" action="<?= CONTENTS_URL.'stage/resume'?>">
		<input type="hidden" name="resume" value="1">
		<?= Asset::img( 'btn/yes.png',
			array('class'=>'modalYes', 'width'=>'27%', 'alt'=>'Yes', 'onclick'=>"document.yesButton.submit()")
		); ?>
		</form>
		<form name="notButton" method="post" action="<?= CONTENTS_URL.'stage/resume'?>">
		<input type="hidden" name="resume" value="0">
		<?= Asset::img( 'btn/no.png',
			array('class'=>'modalNo', 'width'=>'27%', 'alt'=>'No', 'onclick'=>"document.notButton.submit()")
		); ?>
		</form>
	</div>
</div>
<?php elseif(isset($feeluck) && $feeluck): ?>
<div class="modalResult" id="result">
	<div class="resultRelative">
		<div class="resultText">
			所持金が足りません。
		</div>
		<?= Asset::img( 'btn/ok.png',
			array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('result')")
		); ?>
	</div>
</div>
<?php endif; ?>

<?php if(!empty($eventData)): ?>
	<div>イベントダンジョン</div>
	<?php foreach($eventData as $event): ?>
		<form name="form<?= "e".$event['eventId'] ?>" action="<?= CONTENTS_URL.'stage/selectRank'?>" method="post">
			<input type="hidden" name="dungeonRank" value=<?= "e".$event['eventId'] ?>>
			<div class="selectEvent selectEvent<?= $event['eventId']?>" onclick="document.form<?= "e".$event['eventId'] ?>.submit()">
				<div class="holdingPeriod">
					<?= $event['start'] ?>～<?= $event['end'] ?>
				</div>
			</div>
		</form>
	<?php endforeach; ?>
<?php endif; ?>

<div>通常ダンジョン</div>
<?php for($i = 1;$i <= $count;$i++): ?>
	<form name="form<?= $i ?>" action="<?= CONTENTS_URL.'stage/selectRank'?>" method="post">
		<input type="hidden" name="dungeonRank" value=<?= $i ?>>
		<div class="selectLevel selectLevel<?= $i ?>" onclick="document.form<?= $i ?>.submit()">
			<div class="rankcount">
				<?php for($j = 0;$j < $i;$j++): ?>
					<?= Asset::img( 'stage/star.png',
						array('class'=>'rankStar', 'alt'=>'★')
					); ?>
				<?php endfor; ?>
			</div>
			<div class="dungeonname">
				<?= $rankData[$i]['name'] ?>のダンジョン
			</div>
		</div>
	</form>
<?php endfor; ?>

<a href="<?= CONTENTS_URL.'mypage'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>
