function openModal(contentId)
{
	//ボタンからフォーカスを外す
	$(this).blur() ;
	//新しくモーダルウィンドウを起動しない
	if($("#modal-overlay")[0]) return false ;
	
	// オーバーレイ用の要素を追加
	$('body').append('<div class="modalOverlay"></div>');
	// オーバーレイをフェードイン
	$('.modalOverlay').fadeIn('slow');
	// モーダルコンテンツのIDを取得
	var modal = '#' + contentId;
	// モーダルコンテンツの表示位置を設定
	modalResize(modal);
	 // モーダルコンテンツフェードイン
	$(modal).fadeIn('slow');
	// 「.modal-overlay」あるいは「.modal-close」をクリック
	$('.modalClose').off().click(function(){
		closeModal(contentId);
	});
	// リサイズしたら表示位置を再取得
	$(window).on('resize', function(){
		modalResize(modal);
	});
}