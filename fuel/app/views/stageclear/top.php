<?php echo Asset::css('stageclear.css'); ?>

<!--　Clear画像表示 -->
<div class = "clearImg">
</div>

<!-- リザルト背景画像表示 -->
<div id = "resultImgOption">
	<div class = "resultImg">
		<!-- ダンジョン名表示 -->
		<p id = "dangeonName">	<?= $list['name'] ?>	</p>
		<!-- 取得したお金表示 -->
		<p id = "getMoney" >	<?= $money ?> G	</p>
		<!--  アイテムの画像を表示する領域を設定する -->
		<div id = "displayFrame">
			<!-- 配列のmaterialに入ってる値を表示するため　-->
			<?php foreach($material as $materialList):	?>
			<div id = "imgPosition">
				<!-- 素材の画像表示 -->
				<?php foreach($materials as $mData): ?>
					<?php if($mData['id'] == $materialList['id']): ?>
						<?= Asset::img($mData['img'],
							array('id'=>'materialImgSize')
						); ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<!-- 素材の獲得個数を表示 -->
				<p id = "numFontPosition"> x <?= $materialList['count'] ?> </p>
			</div>
			<?php endforeach?>
		</div>
	</div>
</div>

<!-- プレゼント受け取り画面へ -->
<div class = "selectFrame">
	<a id = "presentBoxFont" href="<?= CONTENTS_URL.'present'?>"></a>
</div>

<!-- ステージ選択画面へ -->
<div class = "selectFrame">
	<a id = "selectStageFont" href="<?= CONTENTS_URL.'stage/SelectLevel'?>"></a>
</div>

