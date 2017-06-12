<html>
<head>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />
	<title>e-smile-sys</title>
	<script>
		var homeDir = '<?= CONTENTS_URL?>';
	</script>
	<?php echo Asset::css('contents.css'); ?>
	<?php echo Asset::css('modal.css'); ?>
	<?php echo Asset::js('jquery.js'); ?>
	<?php echo Asset::js('modal.js'); ?>
	<?php echo Asset::js('pager.js'); ?>
	<?php echo Asset::js('gauge.js'); ?>
</head>
<body onload="changeGauge()">

<div class = "headerArea">
	<form name="status">
		<input type="hidden" name="hp" value="<?= $userData['hp']?>">
		<input type="hidden" name="hpMax" value="<?= $userData['hpMax']?>">
		<input type="hidden" name="ap" value="<?= $userData['ap']?>">
		<input type="hidden" name="apMax" value="<?= $userData['apMax']?>">
		<div class = "headerA">
			<div class = "headerImg">
				<div class = "playerName">
					<?= $userData['name']?>
				</div>
				<div class = "Money">
					<?= $userData['money']?>G
				</div>
			</div>
			<div class = "hpGauge">
				<?= Asset::img( 'header/header_hp_bar.png',
					array('height'=>'100%')
				); ?>
			</div>
			<div class = "apGauge">
				<?= Asset::img( 'header/header_ap_bar.png',
					array('height'=>'100%')
				); ?>
			</div>
			<div class = "hpFrame">
				<div class = "headerHp">
					<span id="currentHp"><?= $userData['hp']?></span> / <?= $userData['hpMax']?>
				</div>
			</div>
			<div class = "apFrame">
				<div class = "headerAp">
					<span id="currentAp"><?= $userData['ap']?></span> / <?= $userData['apMax']?>
				</div>
			</div>
		</div>
	</form>
</div>
