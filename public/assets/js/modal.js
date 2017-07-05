$(function(){
var target = '';
	$(".modal_btn").click(
		function(){
			target = $(this).get(0).className.split(" ")[1];
			target = $("#modal-" + target);
			
			// キーボード操作などにより、オーバーレイが多重起動するのを防止する
			$(this).blur() ;	//ボタンからフォーカスを外す
			//新しくモーダルウィンドウを起動しない
			if($("#modal-overlay")[0]) return false ;

			// オーバーレイ用のHTMLコードを、[container]内の最後に生成する
			$("#container").append('<div id="modal-overlay"></div>') ;
			$("#modal-overlay").fadeIn("slow") ;

			// コンテンツをフェードインする
			$(target).fadeIn( "slow" ) ;
		}
	);
	//[#modal-close]をクリックしたら…
	$("#modal-overlay,#modal-close").unbind().click( function(){
		//[#modal-content]と[#modal-overlay]をフェードアウトした後に…
		$(target,"#modal-overlay").fadeOut("slow" , function(){
			//[#modal-overlay]を削除する
			$('#modal-overlay').remove();
		});
	});
});