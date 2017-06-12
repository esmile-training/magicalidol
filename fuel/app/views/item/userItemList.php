<?php echo Asset::css('item.css'); ?>

<div style = "font-size:1.5em; margin-top:5%">
 <?= $msg ?>
</div>

<!-- HP AP 補助　のボタン -->
<div class = "menuBox">
	<div class = "box">
		<a  href="<?= CONTENTS_URL.'item/list/1'?>">
			<div class="hp"></div>
		</a>
	</div>
	<div class = "box">
		<a  href="<?= CONTENTS_URL.'item/list/2'?>">
			<div class="ap"></div>
		</a>			
	</div>
	<div class = "box">
		<a  href="<?= CONTENTS_URL.'item/list/3'?>">
			<div class="support"></div>
		</a>			
	</div>
</div>

<!-- アイテムのリスト表示 -->
<div>
	<?php foreach((array)$userItemList as $item):?>
		<?php if( !isset($itemList[$item['itemId']]) ) continue; ?>
		<?php if($type != 3): ?>
		<div class = "itemList" onclick = "openModal('itemList<?= $item['itemId'] ?>')" >
		<?php else: ?>
		<div  class = "itemList" >
		<?php endif; ?>
			<div>
				<?= Asset::img( $itemList[$item['itemId']] ['img'],
					array('class'=>'itemIcon', 'alt'=>'アイテム')
				); ?>
			</div>	
			<div class = "name">
				<?= $itemList[$item['itemId']] ['name'] ?>
			</div>		
			<div class = "description">
				<?= $itemList[ $item['itemId']] ['description'] ?>
			</div>	
			<div class = "itemNum">
				所持数: <?=$item['count']?> 個
			</div>
		</div>
			<div id="itemList<?= $item['itemId'] ?>" class="itemListModal"  >
				<div>
				<?= Asset::img( $itemList[$item['itemId']] ['img'],
					array('class'=>'itemIconModal', 'alt'=>'アイテム')
				); ?>
				</div>
				
				<div class = "nameModal">
					<?= $itemList[$item['itemId']] ['name'] ?>
				</div>
				
				<?php if($useFlag): ?>
				<div id = "textModal">
					本当に使用してもよろしいですか？
				</div>
				<?php endif;?>
				
				<?php if(!$useFlag): ?>
				<div id = "textModal">
					今は使えないっす
				</div>
				<?php endif;?>
				<form action="<?=CONTENTS_URL?>item/excute" method="post" name = "itemForm<?= $item['itemId']; ?>">
					<input type="hidden"  name="itemId" value="<?=$item['itemId']?>">
					<input type="hidden"  name="categoryId" value="<?=$item['category']?>">
				</form>
				<?php if($useFlag): ?>
				<?= Asset::img( 'item/use.png',
					array('class'=>'yesButton', 'alt'=>'使う', 'onclick'=>'document.itemForm'.$item['itemId'].'.submit()')
				); ?>
				<?php endif;?>
				<?= Asset::img( 'btn/leave.png',
					array('class'=>'noButton', 'alt'=>'やめる', 'onclick'=>"closeModal('itemList".$item['itemId']."')")
				); ?>	
			</div>
	<?php endforeach;?>
</div>

<div style = "margin-top:2%" >
<?= $pagerText?>
</div>