<?php echo Asset::js('test.js'); ?>
<?php echo Asset::css('test.css'); ?>

<h4>テストページ</h4>

<div>startPos:<span id="startPos">0</span></div>
<div>endPos:<span id="endPos">0</span></div>
<div>slidePos:<span id="slidePos">0</span></div>
<div>slideLeft:<span id="slideLeft">0</span></div>
<div class="dungeonSlider">
	<div class="dungeonSlideSet">
		<div class="dungeonSlide">
			<?= Asset::img( 'dungeonBack/rose01.png',
				array('class'=>'bgImg', 'width'=>'100%', 'alt'=>'背景')
			); ?>
		</div>
		<div class="dungeonSlide">
			<?= Asset::img( 'dungeonBack/rose02.png',
				array('class'=>'bgImg', 'width'=>'100%', 'alt'=>'背景')
			); ?>
		</div>
		<div class="dungeonSlide">
			<?= Asset::img( 'dungeonBack/rose01.png',
				array('class'=>'bgImg', 'width'=>'100%', 'alt'=>'背景')
			); ?>
		</div>
		<div class="dungeonSlide">
			<?= Asset::img( 'dungeonBack/rose03.png',
				array('class'=>'bgImg', 'width'=>'100%', 'alt'=>'背景')
			); ?>
		</div>
	</div>
</div>

<div class="borderTest">あいうえお☆/☆☆☆森林</div>

<div>
<?php if($isBattle): ?>
<form name="testForm">
	<select name="words">
		<?php foreach($wordsList as $key=>$value): ?>
			<option value="<?= $key ?>"><?= $value ?></option>
		<?php endforeach; ?>
	</select>
</form>
<div onclick="submitBattle(1)">助言</div>
<div onclick="submitBattle(2)">スキル</div>
<a href="<?= CONTENTS_URL . 'test/end' ?>">戦闘終了</a>
<?php else: ?>
<a href="<?= CONTENTS_URL . 'test/start' ?>">戦闘開始</a>
<?php endif; ?>
</div>

<?= $URI ?><br>
<?= $URI2 ?><br>
<div id="append">
	<div onclick="append()">Append</div>
	<div onclick="prepend()">Prepend</div>
</div>

<table>
	<?php foreach($equipAvatar as $avatarList): ?>
		<tr>
		<?php foreach($avatarList as $avatar): ?>
			<td><?= $avatar?></td>
		<?php endforeach;?>
		</tr>
	<?php endforeach;?>
</table>

<a href="<?= CONTENTS_URL . 'mypage' ?>">
	戻る
</a>

<script>setupSlider(2);</script>