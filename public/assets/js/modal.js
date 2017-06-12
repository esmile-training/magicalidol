$(function(){
// 「.modal-open」をクリック

	$('.modalOpen').click(function(){
		// モーダルコンテンツのIDを取得
		var contentId = $(this).attr('data-target');
		
		openModal(contentId);
	});
});

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
	$('.modalOverlay, .modalClose').off().click(function(){
		closeModal(contentId);
	});
	// リサイズしたら表示位置を再取得
	$(window).on('resize', function(){
		modalResize(modal);
	});
}

function closeModal(contentId)
{
	// モーダルコンテンツのIDを取得
	var modal = '#' + contentId;
	// モーダルコンテンツとオーバーレイをフェードアウト
	$(modal).fadeOut('slow');
	$('.modalOverlay').fadeOut('slow',function(){
		// オーバーレイを削除
		$('.modalOverlay').remove();
	});
}

// モーダルコンテンツの表示位置を設定する関数
function modalResize(modal){
	// ウィンドウの横幅、高さを取得
	var w = $(window).width();
	var h = window.innerHeight;
	// モーダルコンテンツの表示位置を取得
	var x = (w - $(modal).outerWidth(true))/2;
	var y = (h - $(modal).outerHeight(true))/2;

	// モーダルコンテンツの表示位置を設定
	$(modal).css({'left': x + 'px','top': y + 'px'});
}
