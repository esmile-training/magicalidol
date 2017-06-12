<?php echo Asset::css('eventshop.css'); ?>

<?php foreach((array)$eventData as $event): ?>
	<div class="eventRelative">
		<a href="<?= CONTENTS_URL.'eventshop/shop/'.$event['category'].'/'.$event['eventId'] ?>">
			<?= Asset::img( $event['bannerImg'],
				array('class'=>'eventButton', 'alt'=>'戻る')
			); ?>
			<div class="eventPeriod">
				<?= $event['start'] ?>～<?= $event['end'] ?>
			</div>
		</a>
	</div>
<?php endforeach; ?>

<a href="<?= CONTENTS_URL.'shop'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>