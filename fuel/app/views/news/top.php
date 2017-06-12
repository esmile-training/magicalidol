<?php echo Asset::css('top.css'); ?>

<div class="newsImage">
	<div class="newsContents" >
		<?php foreach($newsList as $news):?>
			<div class="news_article" onclick = "openModal('List<?= $news['id'] ?>')">
				<div>
					<div>
						<?=date('Y/m/d',strtotime($news['start']))?>　【<?=$news['title']?>】
					</div>
				</div>
			</div>
			<div id="List<?= $news['id']; ?>" class="modalNews">
				<div class = "newsFrame">
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
			</div>
		<?php endforeach; ?>
	</div>
</div>

<div class="page">
	<?php if($page>1): ?>
		<a href="<?= CONTENTS_URL."news/index/".($page-1)?>">
	<?php endif; ?>
	preview
	<?php if($page>1): ?>
		</a>
	<?php endif; ?>
	&nbsp;&lt;&lt; 
	<?php for($cnt=1; $cnt<=$maxPage; $cnt++): ?>
		<a href="<?= CONTENTS_URL."news/index/".$cnt?>"><?= $cnt ?></a> 
	<?php endfor;?>
	&gt;&gt; 
	<?php if($page<$maxPage): ?>
		<a href="<?= CONTENTS_URL."news/index/".($page+1)?>">
	<?php endif; ?>
	next
	<?php if($page<$maxPage): ?>
		</a>
	<?php endif; ?>
</div>
<div class="news_more">
		<a href="<?= CONTENTS_URL.'top'?>">
			<?= Asset::img( "btn/bBack03.png",
				array("class"=>"more", "width"=>"50%", "alt"=>"More"));?>
		</a>
	</div>


