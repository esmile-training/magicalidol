<?php echo Asset::css('top.css'); ?>

<div>
	<?= Asset::img( 'top/title.png',
		array('width'=>'100%','alt'=>'タイトル')
	); ?>
</div>
<div class="login">
	<a href="<?= CONTENTS_URL.'mypage'?>">
		<?= Asset::img( "top/login_01.png",
				array("class"=>"button", "width"=>"50%", "alt"=>"ログイン", "onmousedown"=>"this.src='".Asset::get_file("top/login_02.png", "img")."'", "onmouseup"=>"this.src='".Asset::get_file("top/login_01.png", "img")."'")
			); ?>
	</a>
</div>
<div class="newsFrame">
	<div class="newsContents">
		<?php foreach($newsList as $news):?>
			<div class="newsContent" onclick = "openModal('List<?= $news['id'] ?>')">
				<?=date('m/d',strtotime($news['start']))?>　<?=$news['title']?>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<?php foreach($newsList as $news):?>
	<div id="List<?= $news['id']; ?>" class="modalNews">
		<div class = "newsDetail">
			<div class = "startView">
				<?= $news['start']?>
			</div>
			<div class = "titleView">
				<?= $news['title']?>
			</div>
			<div class = "textView">
				<?= $news['text']?>
			</div>
		</div>
		<?= Asset::img( 'btn/ok.png',
			array('class'=>'modalOk', 'width'=>'27%', 'alt'=>'OK', 'onclick'=>"closeModal('List".$news['id']."')")
		); ?>
	</div>
<?php endforeach; ?>