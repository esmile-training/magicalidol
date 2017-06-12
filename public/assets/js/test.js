var battleProcess = false;

function submitBattle(actionType)
{
	if(!battleProcess)
	{
		battleProcess = true;
		
		var message = {
			"userId" : 1,
			"actionType" : actionType,
			"advice" : {
				"type" : 1,
			},
			"skill" : {
				"id" : 4,
			},
			"item" : {
				"type" : 3,
				"id" : 1,
			},
			"words" : document.testForm.words.value,
		}
		
		$.ajax({
			type : 'POST',
			url : './battleapi/battle',
			async: false,
			data : JSON.stringify(message),
			contentType: 'application/JSON',
			dataType : 'JSON',
			scriptCharset: 'utf-8',
			success: function(data)
			{
				if(data["result"])
				{
					var text = "";
					
					for(var cnt = 0; cnt < data["log"].length; cnt++)
					{
						text += data["log"][cnt]["message"] + "\n";
					}
					alert(text);
					
					if(data["battleFlg"])
					{
						location.href = './test/end';
					}
				}
				else{
					alert(data["message"]);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				alert("[ERROR]データ送信に失敗しました。\n" + XMLHttpRequest + "\n" + textStatus + "\n" + errorThrown);
			}
		});
		
		battleProcess = false;
	}
}

var count = 0;

function append()
{
	$("#append").append("<div>"+count+"</div>");
	count++;
}
function prepend()
{
	$("#append").prepend("<div>"+count+"</div>");
	count++;
}

//スライダーここから

//初期変数
var dugeonSlideWidth; //スライド横幅
var dugeonSlideWidthHalf; //スライド横幅(半分)
var dungeonSlideHeight; //スライド縦幅
var dungeonSlideNum; //スライド数
var dungeonSlideSetWidth;
var dungeonSlidePos = 0; //スライド位置
var startPosX = 0; //タッチ開始X座標
var startPosY = 0; //タッチ開始Y座標
var endPosX = 0; //タッチ終了X座標
var endPosY = 0; //タッチ終了Y座標
var isSliding = false; //スライド中フラグ
var dungeonSlideOffset = 0;
var reductionRate = 0;
var dungeonImgPolygon;
var dungeonCloneImgPolygon;

//要素変数
var $dungeonSlider   = '.dungeonSlider'; //スライダー表示領域
var $dungeonSlideSet = '.dungeonSlideSet'; //スライド格納領域
var $dungeonSlide    = '.dungeonSlide'; //スライド
var $dungeonSlideImg = '.bgImg'; //スライド背景画像
var $dungeonSlideCloneImg = '.bgImgClone'; //スライド背景画像(複製)
var $dungeonFirstSlide = $dungeonSlide + ':first-child'; //first slide
var $dungeonLastSlide  = $dungeonSlide + ':last-child'; //last slide

//変更可能初期変数
var dungeonSlideTolerance = 30; //スライド許容範囲(%)
var dungeonClickTolerance = 5; //クリック許容範囲半径(px)
var dungeonReductionRate = 75; //スライド時縮小率(%)

//イベントハンドラー設定
$(function()
{
	$($dungeonSlider).on('touchstart',touchHandler);
	$($dungeonSlider).on('touchmove',touchHandler);
	$($dungeonSlider).on('touchend',touchHandler);
	$($dungeonSlider).on('touchcancel',touchHandler);
	$($dungeonSlider).on('mousedown',touchHandler);
	$($dungeonSlider).on('mousemove',touchHandler);
	$($dungeonSlider).on('mouseup',touchHandler);
	$($dungeonSlider).on('mouseout',touchHandler);
	
});

//イベント処理
function touchHandler(e)
{
	e.preventDefault();
	
	//開始(タッチ開始位置を取得してスライド開始)
	if(!isSliding && e.type == "touchstart")
	{
		startPosX = e.originalEvent.targetTouches[0].pageX;
		startPosY = e.originalEvent.targetTouches[0].pageY;
		endPosX = e.originalEvent.targetTouches[0].pageX;
		endPosY = e.originalEvent.targetTouches[0].pageY;
		slideStart();
	}
	if(!isSliding && e.type == "mousedown")
	{
		startPosX = e.pageX;
		startPosY = e.pageY;
		endPosX = e.pageX;
		endPosY = e.pageY;
		slideStart();
	}
	
	//移動(移動距離分スライド)
	if(isSliding && e.type == "touchmove")
	{
		endPosX = e.originalEvent.targetTouches[0].pageX;
		endPosY = e.originalEvent.targetTouches[0].pageY;
		sliding();
	}
	if((isSliding && e.type == "mousemove"))
	{
		endPosX = e.pageX;
		endPosY = e.pageY;
		sliding();
	}
	
	//終了(移動距離に応じて最終移動)
	if(isSliding && ((e.type == "touchend") || (e.type == "touchcancel")))
	{
		slideEnd();
	}
	if(isSliding && ((e.type == "mouseup") || (e.type == "mouseout")))
	{
		slideEnd();
	}
}

//スライド開始
function slideStart()
{
	//debug
	document.getElementById("startPos").innerHTML = startPosX;
	document.getElementById("endPos").innerHTML = endPosX;
	
	if(dungeonSlidePos < 1)
	{
		//現在位置が最初の要素の場合、最後の要素を最初に移動
		$($dungeonLastSlide).css('left', -(dungeonSlideWidth*dungeonSlideNum));
	}
	if(dungeonSlidePos > dungeonSlideNum-2)
	{
		//現在位置が最後の要素の場合、最初の要素を最後に移動
		$($dungeonFirstSlide).css('left', dungeonSlideWidth*dungeonSlideNum);
	}
	
	isSliding = true;
}
//スライド中
function sliding()
{
	var sidePos = dungeonSlidePos;
	var currentSlideHeight = dungeonSlideHeight;
	var sideSlideHeight = dungeonSlideHeight;
	var skewAngle;
	var currentTransOrigin;
	var sideTransOrigin;
	var currentTransOriginClone;
	var sideTransOriginClone;
	var reductionHeight = dungeonSlideHeight;
	var currentPolygon = dungeonImgPolygon;
	var sidePolygon = dungeonImgPolygon;
	var currentClonePolygon = dungeonCloneImgPolygon;
	var sideClonePolygon = dungeonCloneImgPolygon;
	var zIndex = 0;
	var zIndexClone = 1;
	
	//各種計算
	var offset = endPosX-startPosX;
	var offsetAbs = Math.abs(offset);
	
	//縮小値を計算
	if((offsetAbs) < dungeonSlideWidth/2)
	{ //縮小
		reductionHeight -= reductionRate*offsetAbs;
	}
	else
	{ //拡大
		reductionHeight = reductionHeight*(dungeonReductionRate/100)+reductionRate*(offsetAbs-(dungeonSlideWidth/2));
	}
	skewAngle = -Math.atan2((dungeonSlideHeight-reductionHeight)/2, dungeonSlideWidth)*180/Math.PI;
	if(offset<0)
	{
		if(++sidePos > dungeonSlideNum-1)
		{
			sidePos = 0;
		}
		currentTransOrigin = "left top";
		sideTransOrigin = "right top";
		currentTransOriginClone = "left bottom";
		sideTransOriginClone = "right bottom";
		currentSlideHeight = reductionHeight;
		zIndex = 1;
		zIndexClone = 0;
		sidePolygon = "";
		currentClonePolygon = "";
	}
	else
	{
		if(--sidePos < 0)
		{
			sidePos = dungeonSlideNum-1;
		}
		currentTransOrigin = "right top";
		sideTransOrigin = "left top";
		currentTransOriginClone = "right bottom";
		sideTransOriginClone = "left bottom";
		skewAngle *= -1;
		sideSlideHeight = reductionHeight;
		currentPolygon = "";
		sideClonePolygon = "";
	}
	
	//移動
	$($dungeonSlideSet).css({
		"left": -1*dungeonSlidePos*dungeonSlideWidth + offset,
	});
	
	//現在のスライドに変形を適用
	$($dungeonSlideImg+':eq('+dungeonSlidePos+')').css({
		"height": sideSlideHeight,
		"transform-origin": currentTransOrigin,
		"transform": "skewY("+(-skewAngle)+"deg)",
		"-webkit-clip-path": currentPolygon,
		"clip-path": currentPolygon,
		"z-index": zIndex,
	});
	$($dungeonSlideCloneImg+':eq('+dungeonSlidePos+')').css({
		"height": currentSlideHeight,
		"transform-origin": currentTransOriginClone,
		"transform": "skewY("+skewAngle+"deg)",
		"-webkit-clip-path": currentClonePolygon,
		"clip-path": currentClonePolygon,
		"z-index": zIndexClone,
	});
	//横のスライドに変形を適用
	$($dungeonSlideImg+':eq('+sidePos+')').css({
		"height": currentSlideHeight,
		"transform-origin": sideTransOrigin,
		"transform": "skewY("+skewAngle+"deg)",
		"-webkit-clip-path": sidePolygon,
		"clip-path": sidePolygon,
		"z-index": zIndexClone,
	});
	$($dungeonSlideCloneImg+':eq('+sidePos+')').css({
		"height": sideSlideHeight,
		"transform-origin": sideTransOriginClone,
		"transform": "skewY("+(-skewAngle)+"deg)",
		"-webkit-clip-path": sideClonePolygon,
		"clip-path": sideClonePolygon,
		"z-index": zIndex,
	});
	
	//debug
	document.getElementById("endPos").innerHTML = endPosX;
	document.getElementById("slideLeft").innerHTML = -1*dungeonSlidePos*dungeonSlideWidth + offset;
}
//スライド終了
function slideEnd()
{
	var currentPos = dungeonSlidePos;
	
	//移動量を計算
	var offsetX = endPosX-startPosX;
	var offsetY = endPosY-startPosY;
	
	//クリックチェック
	if((Math.abs(offsetX) < dungeonClickTolerance) && (Math.abs(offsetY) < dungeonClickTolerance))
	{
		clickEvent();
	}
	
	//許容範囲以上の移動の場合現在位置を変更
	if(offsetX > dungeonSlideOffset)
	{
		dungeonSlidePos--;
	}
	else if(offsetX*-1 > dungeonSlideOffset)
	{
		dungeonSlidePos++;
	}
	
	//最終位置調整
	$($dungeonSlideSet).stop(true, false).animate({
		left: -1*dungeonSlidePos*dungeonSlideWidth
	},{
		//アニメーション中処理
		step: function(now, fx){
			var sidePos = currentPos;
			var offset = now+1*dungeonSlidePos*dungeonSlideWidth;
			var offsetAbs = Math.abs(offset);
			var currentSlideHeight = dungeonSlideHeight;
			var sideSlideHeight = dungeonSlideHeight;
			var reductionHeight = dungeonSlideHeight;
			var skewAngle;
			var currentTransOrigin;
			var sideTransOrigin;
			var currentTransOriginClone;
			var sideTransOriginClone;
			var currentPolygon = dungeonImgPolygon;
			var sidePolygon = dungeonImgPolygon;
			var currentClonePolygon = dungeonCloneImgPolygon;
			var sideClonePolygon = dungeonCloneImgPolygon;
			var zIndex = 0;
			var zIndexClone = 1;
			
			//縮小値を計算
			if((offsetAbs) < dungeonSlideWidth/2)
			{ //縮小
				reductionHeight -= reductionRate*offsetAbs;
				// reductionHeight = reductionHeight*(dungeonReductionRate/100)+reductionRate*offsetAbs;
			}
			else
			{ //拡大
				// reductionHeight = reductionHeight*(dungeonReductionRate/100)+reductionRate*(offsetAbs-(dungeonSlideWidth/2));
				reductionHeight = reductionHeight*(dungeonReductionRate/100)+reductionRate*(offsetAbs-(dungeonSlideWidth/2));
			}
			
			if(currentPos < dungeonSlidePos)
			{ //次のスライドに移動する場合
				currentTransOrigin = "left top";
				sideTransOrigin = "right top";
				currentTransOriginClone = "left bottom";
				sideTransOriginClone = "right bottom";
				
				currentSlideHeight = reductionHeight;
				zIndex = 1;
				zIndexClone = 0;
				sidePolygon = "";
				currentClonePolygon = "";
				
				skewAngle = -Math.atan2((dungeonSlideHeight-reductionHeight)/2, dungeonSlideWidth)*180/Math.PI;
				
				sidePos = dungeonSlidePos;
			}
			else if(currentPos > dungeonSlidePos)
			{ //前のスライドに移動する場合
				currentTransOrigin = "right top";
				sideTransOrigin = "left top";
				currentTransOriginClone = "right bottom";
				sideTransOriginClone = "left bottom";
				
				sideSlideHeight = reductionHeight;
				currentPolygon = "";
				sideClonePolygon = "";
				
				skewAngle = Math.atan2((dungeonSlideHeight-reductionHeight)/2, dungeonSlideWidth)*180/Math.PI;
				
				sidePos = dungeonSlidePos;
			}
			else
			{ //スライドが元に戻る場合
				slideHeight = dungeonSlideHeight - reductionRate*offsetAbs;
				skewAngle = -Math.atan2((dungeonSlideHeight-reductionHeight)/2, dungeonSlideWidth)*180/Math.PI;
				
				if(offset<0)
				{
					currentSlideHeight = reductionHeight;
					zIndex = 1;
					zIndexClone = 0;
					currentTransOrigin = "left top";
					sideTransOrigin = "right top";
					currentTransOriginClone = "left bottom";
					sideTransOriginClone = "right bottom";
					sidePolygon = "";
					currentClonePolygon = "";
					sidePos++;
				}
				else
				{
					sideSlideHeight = reductionHeight;
					currentTransOrigin = "right top";
					sideTransOrigin = "left top";
					currentTransOriginClone = "right bottom";
					sideTransOriginClone = "left bottom";
					currentPolygon = "";
					sideClonePolygon = "";
					sidePos--;
					skewAngle *= -1;
				}
			}
			
			if(sidePos > dungeonSlideNum-1)
			{
				sidePos = 0;
			}
			if(sidePos < 0)
			{
				sidePos = dungeonSlideNum-1;
			}
			
			//現在のスライドに変形を適用
			$($dungeonSlideImg+':eq('+currentPos+')').css({
				"height": sideSlideHeight,
				"transform-origin": currentTransOrigin,
				"transform": "skewY("+(-skewAngle)+"deg)",
				"-webkit-clip-path": currentPolygon,
				"clip-path": currentPolygon,
				"z-index": zIndex,
			});
			$($dungeonSlideCloneImg+':eq('+currentPos+')').css({
				"height": currentSlideHeight,
				"transform-origin": currentTransOriginClone,
				"transform": "skewY("+skewAngle+"deg)",
				"-webkit-clip-path": currentClonePolygon,
				"clip-path": currentClonePolygon,
				"z-index": zIndexClone,
			});
			//横のスライドに変形を適用
			$($dungeonSlideImg+':eq('+sidePos+')').css({
				"height": currentSlideHeight,
				"transform-origin": sideTransOrigin,
				"transform": "skewY("+skewAngle+"deg)",
				"-webkit-clip-path": sidePolygon,
				"clip-path": sidePolygon,
				"z-index": zIndexClone,
			});
			$($dungeonSlideCloneImg+':eq('+sidePos+')').css({
				"height": sideSlideHeight,
				"transform-origin": sideTransOriginClone,
				"transform": "skewY("+(-skewAngle)+"deg)",
				"-webkit-clip-path": sideClonePolygon,
				"clip-path": sideClonePolygon,
				"z-index": zIndex,
			});
			
			//debug
			document.getElementById("slideLeft").innerHTML = now;
			// console.log(skewAngle);
		},
		//アニメーション終了時処理
		complete: function(){
			//移動していた要素を元に戻す
			$($dungeonLastSlide).css('left', '');
			$($dungeonFirstSlide).css('left', 0);
			
			//画像の変形を元に戻す
			$($dungeonSlideImg).css({
				'height': dungeonSlideHeight,
				"transform": "",
				"-webkit-clip-path": "",
				"clip-path": "",
				"z-index": 0,
			});
			$($dungeonSlideCloneImg).css({
				'height': dungeonSlideHeight,
				"transform": "",
				"-webkit-clip-path": dungeonCloneImgPolygon,
				"clip-path": dungeonCloneImgPolygon,
				"z-index": 1,
			});
			
			//スライド範囲を超えた場合、位置調整
			if(dungeonSlidePos < 0)
			{
				$($dungeonSlideSet).css('left', -(dungeonSlideWidth*(dungeonSlideNum-1)));
				dungeonSlidePos = dungeonSlideNum-1;
				
				//debug
				document.getElementById("slideLeft").innerHTML = -(dungeonSlideWidth*(dungeonSlideNum-1));
			}
			if(dungeonSlidePos > dungeonSlideNum-1)
			{
				$($dungeonSlideSet).css('left', 0);
				dungeonSlidePos = 0;
				
				//debug
				document.getElementById("slideLeft").innerHTML = 0;
			}
			
			//debug
			document.getElementById("endPos").innerHTML = endPosX;
			document.getElementById("slidePos").innerHTML = dungeonSlidePos;
		},
	});
	
	isSliding = false;
}

//クリック時処理
function clickEvent()
{
	alert('Cick!');
}

//スライダー初期設定
function setupSlider(slidePos)
{
	if(slidePos == null)
	{
		slidePos = 0;
	}
	dungeonSlidePos = slidePos;
	var $clone;
	
	//各種情報を取得
	dungeonSlideNum = $($dungeonSlide).length;
	dungeonSlideWidth = $(window).width();
	// dungeonSlideHeight = $($dungeonSlideImg).height();
	dungeonSlideHeight = dungeonSlideWidth/16*9;
	//各種情報を計算
	dungeonSlideSetWidth = dungeonSlideWidth * (dungeonSlideNum+2);
	dungeonSlideOffset = dungeonSlideWidth*dungeonSlideTolerance/100;
	dungeonSlideWidthHalf = dungeonSlideWidth/2;
	reductionRate = (dungeonSlideHeight*((100-dungeonReductionRate)/100))/(dungeonSlideWidth/2);
	
	//CSSに設定
	$($dungeonSlideImg).css({
		"width": dungeonSlideWidth,
		"height": dungeonSlideHeight,
	});
	$($dungeonSlide).css({
		"width": dungeonSlideWidth,
		"height": dungeonSlideHeight,
	});
	$($dungeonSlideSet).css({
		"width": dungeonSlideSetWidth,
		"height": dungeonSlideHeight,
		"marginLeft": -dungeonSlideWidth,
		"paddingLeft": dungeonSlideWidth,
		"left": -1*dungeonSlidePos*dungeonSlideWidth,
	});
	$($dungeonSlider).css({
		"width": dungeonSlideWidth,
		"height": dungeonSlideHeight,
		"overflow":"hidden",
	});
	
	dungeonImgPolygon = "polygon(0px 0px, "+dungeonSlideWidth+"px 0px, 0px "+dungeonSlideHeight+"px)";
	dungeonCloneImgPolygon = "polygon(0px "+dungeonSlideHeight+"px, "+dungeonSlideWidth+"px 0px, "+dungeonSlideWidth+"px "+dungeonSlideHeight+"px)";
	
	//画像の複製がすでにある場合は削除
	$($dungeonSlideCloneImg).remove();
	//画像の複製を作成
	for(var cnt=0; cnt<dungeonSlideNum; cnt++)
	{
		$($dungeonSlideImg+':eq('+cnt+')').clone().removeClass('bgImg').addClass('bgImgClone').appendTo($dungeonSlide+':eq('+cnt+')');
	}
	$($dungeonSlideCloneImg).css({
		"-webkit-clip-path": dungeonCloneImgPolygon,
		"clip-path": dungeonCloneImgPolygon,
	});
	
	//debug
	document.getElementById("slidePos").innerHTML = dungeonSlidePos;
}