<div id="modal-<?= $name ?>" class="modal-content-<?= $size ?>">
	<?php //引き渡しデータがある場合 ?>
	<?php if(isset($popup_data)){ ?>
		<?= View::forge('popup/'.$name, array('popup_data'=>$popup_data)) ?>
	<?php //引き渡しデータがない場合 ?>
	<?php }else{ ?>
		<?= View::forge('popup/'.$name) ?>
	<?php } ?>
	<?php //ポップアップウィンドウを閉じる ?>
	<p><a id="modal-close">閉じる</a></p>
</div>