<?php echo Asset::css('mypage.css'); ?>
<div class="avatar">

	<?= Asset::img( $weapon['boyimg'],
		array( 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( $room['img'],
		array('class'=> 'bg', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( $avatar['a']['img'],
		array('class'=> 'a1', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( 'avatar/body.png',
		array('class'=> 'body', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( $avatar['b']['img'],
		array('class'=> 'b', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( $avatar['c']['img'],
		array('class'=> 'c', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( $avatar['d']['img'],
		array('class'=> 'd', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( $avatar['a']['img2'],
		array('class'=> 'a2', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( $avatar['e']['img'],
		array('class'=> 'e', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
	<?= Asset::img( $armor['img'],
		array('class'=> 'armor', 'width'=> '100%', 'alt'=>'アバター')
	); ?>
</div>

 <div class ="statusFrame">
	<div class = "weaponStatus">
		武　器 ：<?= $weapon['name']?><? if($weapon['strengthening']){ print "+".$weapon['strengthening']; } ?>
	</div>
	<div class = "armorStatus">
		防　具 ：<?= $armor['name']?>
	</div>			
	<div class = "skillStatus">	
		スキル ：<?= $weapon['skillName']?>
	</div>
	<div class = "attackStatus">
		攻撃 ： <?= $weapon['status']?> 
	</div>
	<div class = "defenseStatus">
		防御 ： <?= $armor['status']?> 
	</div>
	<div class = "avoidanceStatus">
		回避 ： <?= $avatar['total']['luckPoint']?> 
	</div>
</div>

<div class="my_menu">
	<div style="margin: 10px">
		<a href="<?= CONTENTS_URL.'stage/selectLevel'?>">
			<div class="stage"></div>
		</a>
		<a href="<?= CONTENTS_URL.'compound'?>">
			<div class="arms"></div>
		</a>
	</div>
	<div style="margin: 10px 0">
		<a href="<?= CONTENTS_URL.'equipment'?>">
			<div class="equip"></div>
		</a>
		<a href="<?= CONTENTS_URL.'item'?>">
			<div class="item"></div>
		</a>
	</div>
	<div style="margin: 10px 0">
		<a href="<?= CONTENTS_URL.'shop'?>">
			<div class="shop"></div>
		</a>
		<a href="<?= CONTENTS_URL.'present'?>">
			<div class="present"></div>
		</a>
	</div>
</div>