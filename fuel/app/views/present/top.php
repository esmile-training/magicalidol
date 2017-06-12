<?php echo Asset::js('present.js'); ?>
<?php echo Asset::css('present.css'); ?>

<h4>プレゼント受け取りBOX</h4>

<p><?= $msg ?></p>

<form action="<?= CONTENTS_URL.'present'?>" method="post" name="dataForm">
	<input type="hidden" name="page" value="1">
	<select name="category" onchange="document.dataForm.submit()">
		<?php foreach($categoryList as $id=>$value): ?>
			<?php if($id == $category): ?>
				<option value="<?= $id; ?>" selected><?= $value; ?></option>
			<?php else: ?>
				<option value="<?= $id; ?>"><?= $value; ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>
</form>

<div class="presentContents">

	<div class="buttons">
		<form action="<?= CONTENTS_URL.'present/getallpresent'?>" method="post" name="presentSelectForm">
			<?php foreach((array)$presentViewList as $present): ?>
				<input type="hidden" class="presentValue" name="id<?= $present['id'] ?>" id="id<?= $present['id'] ?>" value="0">
			<?php endforeach; ?>
			<input type="hidden" name="page" value="<?= $page ?>">
			<?=	Asset::img('btn/allraceive.png',
				array('class'=>'allrecieve', 'width'=>'100%', 'alt'=>'一括受け取り','onclick'=>'document.presentSelectForm.submit()')
			); ?>
		</form>
		<?= Asset::img( 'btn/allselect.png',
			array('class'=>'allselect', 'alt'=>'全選択','id'=>'allselect')
		); ?>
	</div>
	<?php foreach ((array)$presentViewList as $present): ?>
		<form action="<?= CONTENTS_URL.'present/getpresent'?>" method="post" name="presentForm<?= $present['id'] ?>">
			<input type="hidden" name="id" value="<?= $present['id'] ?>">
			<input type="hidden" name="page" value="<?= $page ?>">
			<div class = "presentContent" id="content<?= $present['id'] ?>" onclick="selectChange(<?= $present['id'] ?>)">
				<?=	Asset::img($present['thumbnail'],
					array('class'=>'thumbnail', 'width'=>'100%', 'alt'=>'プレゼント')
				); ?>
				<div class="presentText">
					<?= $present['name'] ?>×<?= $present['count'] ?>
				</div>
				<div class="recieveButton">
					<?=	Asset::img('btn/receive.png',
						array('class'=>'simplerecieve', 'width'=>'100%', 'alt'=>'単体受け取り','onclick'=>'document.presentForm'.$present['id'].'.submit()')
					); ?>
				</div>
			</div>
		</form>				
	<?php endforeach; ?>
</div>

<?php if(isset($pagerText)):?>
	<?php echo $pagerText; ?>
<?endif;?>

<script>
	$('.allselect').on('click', function() {
		var flg = 0;
		$('.presentValue').each(function(){
			var id = this.id.split("d")[1];
			if($('#id'+id).val() == "0")
			{
				console.log('pass');
				$('#content'+id).click();
				flg = 1;
			}
		});
		if(flg == 0)
		{
			console.log('pass2');
			$('.presentContent').click();
		}
	});
	function changePage(pageNum)
	{
		document.dataForm.page.value = pageNum;
		document.dataForm.submit();
	}
</script>

<a href="<?= CONTENTS_URL.'mypage'?>">
	<?= Asset::img( 'btn/bBack03.png',
		array('class'=>'backButton', 'alt'=>'戻る')
	); ?>
</a>

<?php if(isset($pageText)):?>
<?php echo $pagerText; ?>
<?php endif;?>
