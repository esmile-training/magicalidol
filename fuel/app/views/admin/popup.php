<div>
	<?php // リンクのポップアップ化 ?>
	<?php // class = "moda_btn 開くポップアップのファイル名" ポップアップを開くボタン化 ?>
	<p><a class="modal_btn abc">クリックするとabcモーダルウィンドウを開きます。</a></p>
	<p><a class="modal_btn def">クリックするとdefモーダルウィンドウを開きます。</a></p>
	<p><a class="modal_btn ghi">クリックするとghiモーダルウィンドウを開きます。</a></p>
</div>

<?php // ポップアップの呼び出し ?>
<?php // 'name' => 'ポップアップのファイル名' ?>
<?php // 'size' => 'ポップアップのサイズ(big,normal,small)' ?>
<?php // 'value' => 引き渡しデータ ?>
<?= View::forge('popup/wrap', array('name' => 'abc', 'size' => 'big', 'popup_data' => $value)); ?>
<?= View::forge('popup/wrap', array('name' => 'def', 'size' => 'normal')); ?>
<?= View::forge('popup/wrap', array('name' => 'ghi', 'size' => 'small')); ?>
