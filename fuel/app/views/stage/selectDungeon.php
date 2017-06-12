<?php echo Asset::css('selectstage.css'); ?>


<?php foreach((array)$stageData as $id => $stage): ?>
	<?php if(!is_null($progress) && ($id > $progress+1)){ break; } ?>
	<a href="<?= CONTENTS_URL.'stage/dungeonStart/'.$rank.'/'.$id ?>">
		<div class="selectLevel selectLevel<?= $rank ?>">
			<div class="rankcount">
				<?php for($i = 0;$i < $id;$i++): ?>
					<?= Asset::img( 'stage/star.png',
						array('class'=>'rankStar', 'alt'=>'★')
					); ?>
				<?php endfor; ?>
			</div>
			<div class="dungeonName"><?= $stage['name'] ?></div>
			<div class="fee"><?= $stage['fee'] ?>G</div>
		</div>
	</a>
<?php endforeach; ?>

<a href="<?= CONTENTS_URL.'stage/SelectLevel'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>