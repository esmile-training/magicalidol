var startPos = 0;//最初にタッチした場所
var endPos = 0;//タッチをやめた場所
var direction = 0;//向き0＝北、１＝東、２＝南、３＝西
var goalFlg = 0;
var flg = false;
var direction = 0;
var rotation = 0;
// var homeDir = "./../";

$(function()
{

	//$(document).on('ready',setupStage);
	$(document).on('ready',setDirection);
	//$(document).on('ready',changeGauge);
	changeGauge();
	$(".apGauge").css({
		"transition": "all 0.5s ease-in-out",
	});
	tutorialAnimation();
});

function tutorialAnimation()
{
	$(".tutorialTouch").animate({
		top: "40%",
		"font-size": "1em",
		opacity: 0,
	},{
		duration: 0,
		complete: function(){
			$(".tutorialSlide1").animate({
				left: "60%",
				opacity: 0,
			});
			$(".tutorialSlide2").animate({
				left: "-60%",
				opacity: 0,
			}).on("transitionend", function(){
				$(".tutorialWord").off("transitionend").remove();
				$(".tutorialOverlay").remove();
			});
		}
	});
}

//画面更新時にgoalFlgとdirectionを取得する。
function setDirection()
{
	dungeonSlidePos = Number(document.dungeonForm.direction.value);
	direction = Number(document.dungeonForm.direction.value);
	rotation = -90 * dungeonSlidePos;
	$(".compassBase").css(
			{
				"transform": "rotateZ("+rotation+"deg)",
			}).off("transitionend");
	//direction = Number(document.dungeonForm.direction.value);
	setupSlider(dungeonSlidePos);

}

function setLoading()
{
	$(".loadBg").height($(".back").height());
	$(".loadBg").fadeIn();
	$(".back").append('<div class="loadImg"><img src="'+homeDir+'public/assets/img/etc/now_loading.gif"></div>');
}

function unsetLoading()
{
	$(".loadImg").remove();
	$(".loadBg").fadeOut();
}

function walk(userId)
{

	if(!flg)
	{
		flg = true;
		setLoading();
		
		var data = 
		{
			"direction" :dungeonSlidePos,
			"userId" : userId,
		};
		
		$.ajax(
		{
			type : 'POST',
			url : homeDir + 'dungeonapi/walk',
			async: true,
			data : JSON.stringify(data),
			contentType: 'application/JSON',
			dataType : 'JSON',
			scriptCharset: 'utf-8',
			success: function(result)
			{
				unsetLoading();
				
				setupSlider(dungeonSlidePos);
				if(result['result'])
				{
					changeAp(result['ap']);
					//バトルに入ったかチェックする
					if(Number(result["battle"]) != 0)
					{
						document.battleForm.bossFlg.value = 0;
						if(Number(result["boss"]) == 1)
						{
							document.battleForm.bossFlg.value = 1;
						}
						eventEfect(result);
						document.battleForm.submit();
						return;
					}
					if(Number(result["goalFlg"]) == 1)
					{
						eventEfect(result);
						document.clearForm.submit();
						return;
					}
					if(Number(result["getItem"]) == 1)
					{
						openModal("item");
					}
					
					$('.startPos').css('z-index',0);
					$('.boss').css('z-index',0);
					
					//画像をコピーする。z-indexもここで指定する。
					$(".expansion").attr('src',homeDir + "public/assets/img/"+result["passImg"]);
					$(".expansion").css({
						"z-index": 30,
					});
					$(".expansionFrame").css({
						"z-index": 30,
					});
					//ボスがあれば、ボス画像もコピーする？
					//0
					switch(Number(result["north"]))
					{
						case 0:
						{
							$('.northImg').attr('src',homeDir + "public/assets/img/"+result["notPassImg"]);
							break;
						}
						case 1:
						{
							$('.northImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							break;
						}
						case 2:
						{
							$('.northImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.nStart').attr('src',homeDir + "public/assets/img/"+result["startImg"]);
							$('.startPos').css("z-index",20);
							break;
						}
						case 3:
						{
							$('.northImg').attr('src',homeDir + "public/assets/img/"+result["goalImg"]);
							break;
						}
						case 4:
						{
							$('.northImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.nBoss').attr('src',homeDir + "public/assets/img/"+result["bossImg"]);
							$('.boss').css('z-index',20);
							break;
						}
						case 5:
						{
							$('.northImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.nBoss').attr('src',homeDir + "public/assets/img/"+result["bossImg"]);
							$('.boss').css('z-index',20);
							break;
						}
						default:
						{
							$('.northImg').attr('src',homeDir + "public/assets/img/"+result["notPassImg"]);
							break;
						}
					}
					//1
					switch(Number(result["east"]))
					{
						case 0:
						{
							$('.eastImg').attr('src',homeDir + "public/assets/img/"+result["notPassImg"]);
							break;
						}
						case 1:
						{
							$('.eastImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							break;
						}
						case 2:
						{
							$('.eastImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.eStart').attr('src',homeDir + "public/assets/img/"+result["startImg"]);
							$('.startPos').css("z-index",20);
							break;
						}
						case 3:
						{
							$('.eastImg').attr('src',homeDir + "public/assets/img/"+result["goalImg"]);
							break;
						}
						case 4:
						{
							$('.eastImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.eBoss').attr('src',homeDir + "public/assets/img/"+result["bossImg"]);
							$('.boss').css('z-index',20);
						break;
						}
						case 5:
						{
							$('.eastImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.eBoss').attr('src',homeDir + "public/assets/img/"+result["bossImg"]);
							$('.boss').css('z-index',20);
						break;
						}
						default:$('.eastImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);break;
					}
					//2
					switch(Number(result["south"]))
					{
						case 0:
						{
							$('.southImg').attr('src',homeDir + "public/assets/img/"+result["notPassImg"]);
							break;
						}
						case 1:
						{
							$('.southImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							break;
						}
						case 2:
						{
							$('.southImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.sStart').attr('src',homeDir + "public/assets/img/"+result["startImg"]);
							$('.startPos').css("z-index",20);
							break;
						}
						case 3:
						{
							$('.southImg').attr('src',homeDir + "public/assets/img/"+result["goalImg"]);
							break;
						}
						case 4:
						{
							$('.southImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.sBoss').attr('src',homeDir + "public/assets/img/"+result["bossImg"]);
							$('.boss').css('z-index',20);
						break;
						}
						case 5:
						{
							$('.southImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.sBoss').attr('src',homeDir + "public/assets/img/"+result["bossImg"]);
							$('.boss').css('z-index',20);
						break;
						}
						default:
						{
							$('.southImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							break;
						}
					}
					//3
					switch(Number(result["west"]))
					{
						case 0:
						{
							$('.westImg').attr('src',homeDir + "public/assets/img/"+result["notPassImg"]);
							break;
						}
						case 1:
						{
							$('.westImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							break;
						}
						case 2:
						{
							$('.westImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.wStart').attr('src',homeDir + "public/assets/img/"+result["startImg"]);
							$('.startPos').css("z-index",20);
							break;
						}
						case 3:
						{
							$('.westImg').attr('src',homeDir + "public/assets/img/"+result["goalImg"]);
							break;
						}
						case 4:
						{
							$('.westImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.wBoss').attr('src',homeDir + "public/assets/img/"+result["bossImg"]);
							$('.boss').css('z-index',20);
							break;
						}
						case 5:
						{
							$('.westImg').attr('src',homeDir + "public/assets/img/"+result["passImg"]);
							$('.wBoss').attr('src',homeDir + "public/assets/img/"+result["bossImg"]);
							$('.boss').css('z-index',20);
						break;
						}
						default:$('.westImg').attr('src',homeDir + "public/assets/img/"+result["notPassImg"]);break;
					}
					
					//コピーした画像をアニメーションで拡大させながら透過する。
					
					$(".expansion").css(
					{
						"transition": "all 1s ease-in-out",
						"transform": "scale(4)",
						"opacity": 0,
					}).on("transitionend",function()
					{
						$(this).css(
						{
							"transform": "",
						}).off("transitionend").on("transitionend", function()
						{
							$(this).css(
							{
								"transition": "",
								"z-index":"0",
								"opacity": 1,
							}).off("transitionend");
							$(".expansionFrame").css({
								"z-index":"0",
							});
						});
					});
				}
				else
				{
					if(result["isBattle"])
					{
						location.href = homeDir + "battle";
					}
					else if(result["wall"])
					{
						openModal("wall");
					}
					else
						alert(result["message"]);
				}
				//log表示
				//ログ追加
				$(".logText").prepend(result["log"] + "<br>\n");
				
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				alert("[ERROR]データ送信に失敗しました。\n" + XMLHttpRequest + "\n" + textStatus + "\n" + errorThrown);
				unsetLoading();
			}
		});
		
		flg = false;
	}
}

function changeAp(value)
{
	document.status.ap.value = value;
	$("#currentAp").html(value);
	changeGauge();
	$(".apGauge").css({
		"transition": "",
	});
}
function changeHp(value)
{
	document.status.hp.value = value;
	$("#currentHp").html(value);
	changeGauge();
	$(".hpGauge").css({
		"transition": "",
	});
}

function eventEfect(result)
{
	$(".northImg").attr('src',"");
	$(".eastImg").attr('src',"");
	$(".southImg").attr('src',"");
	$(".westImg").attr('src',"");
	if(Number(result["battle"]) == 1)
	{
		$(".expansion").attr('src',"../public/assets/img/"+result["passImg"]);
	}
	if(Number(result["goalFlg"]) == 1)
	{
		$(".dungeonSlide").css({"background-color":"white"});
		$(".expansion").attr('src',"../public/assets/img/"+result["goalImg"]);
	}
	$(".expansion").css({
		"z-index": 30,
	});
	$(".expansionFrame").css({
		"z-index": 30,
	});
	$(".goalEfect").css({
		"opacity": 1,
	});
	$(".expansion").css(
	{
		"transition": "all 1s ease-in-out",
		"transform": "scale(4)",
		"opacity": 0.5,
	}).off("transitionend");
}

function rotateCompass()
{
	//ダンジョンの方角と今見ている方角を比べる
	switch(direction - dungeonSlidePos)
	{
		case -1:
		{
			rotation -= 90;
			break;
		}
		case 1:
		{
			rotation += 90;
			break;
		}
		case 3:
		{
			rotation -= 90;
			break;
		}
		case -3:
		{
			rotation += 90;
			break;
		}
	}
	
	$(".compassBase").css(
	{
		"transition": "all 1s ease-in-out",
		"transform": "rotate("+rotation+"deg)",
	}).on("transitionend",function()
	{
		if(Math.abs(rotation) == 360)
		{
			rotation = 0;
			$(this).css(
			{
				"transition": "",
				"transform": "rotate(0deg)",
			}).off("transitionend");
		}
		else
		{
			$(this).off("transitionend");
		}
	});

	direction = dungeonSlidePos;

}
function displayItemRecover()
{
	$(".itemRecover").css({
		"display": "block",
	});
	$(".itemAp").css({
		"display": "none",
	});
}
function displayItemApRecover()
{
	$(".itemRecover").css({
		"display": "none",
	});
	$(".itemAp").css({
		"display": "block",
	});
}
function useItem(value, type, id)
{
	setLoading();
	var data = 
		{
			"value" : value,
			"type" : type,
			"id" : id,
		};
	closeModal('itemList');
	
	$.ajax({
			type : 'POST',
			url : homeDir + 'dungeonapi/useItem',
			data : JSON.stringify(data),
			contentType: 'application/JSON',
			dataType : 'JSON',
			scriptCharset: 'utf-8',
			success: function(data)
			{
				if(data["result"]) //通常処理
				{
					if(data["type"] == 1)
					{
						changeHp(Number(data["value"]));
					}
					else if(data["type"] == 2)
					{
						changeAp(Number(data["value"]));
					}
				}
				else
				{
					if(data["isBattle"])
					{
						location.href = homeDir + "battle";
					}
					else
						alert(data["message"]);
				}
				unsetLoading();
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				alert("[ERROR]データ送信に失敗しました。\n" + XMLHttpRequest + "\n" + textStatus + "\n" + errorThrown);
				unsetLoading();
			}
	});
}

