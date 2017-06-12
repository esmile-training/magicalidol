var isBattle = false;
var hpVarWidth;
var skillFlg;
var battleSpeed = 1;
var logInterval = 1500;
var animateTime = logInterval/3*2;

var message = {
	"battle.js": "load"
};
debugSubmit(message);

function submitBattle(actionType, type, id)
{
	if(type == null)
	{
		type = 0;
	}
	if(id == null)
	{
		id = 0;
	}
	
	if(!isBattle)
	{
		isBattle = true;
		
		$(".commandOverlay").fadeIn();
		//NowLoadingを表示
		setLoading();
		
		var message = {
			"actionType" : actionType,
		};
		switch(actionType)
		{
			case 1: //助言
				message["advice"] = {
					"type" : type,
				};
				break;
			case 3: //アイテム
				message["item"] = {
					"type" : type,
					"id" : id,
				};
				closeModal('itemList');
				break;
		}
		
		$.ajax({
			type : 'POST',
			url : './battleapi/battle',
			// async: false,
			data : JSON.stringify(message),
			contentType: 'application/JSON',
			dataType : 'JSON',
			scriptCharset: 'utf-8',
			success: function(data)
			{
				if(data["result"]) //通常処理
				{
					//NowLoadingを解除
					unsetLoading();
					battleProcess(data);
				}
				else{ //エラー処理
					alert(data["message"]);
					$(".commandOverlay").fadeOut();
					unsetLoading();
					isBattle = false;
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				alert("[ERROR]データ送信に失敗しました。\n" + XMLHttpRequest + "\n" + textStatus + "\n" + errorThrown);
				$(".commandOverlay").fadeOut();
				unsetLoading();
				isBattle = false;
			}
		});
	}
}

function battleProcess(data)
{
	skillFlg = 0;
	
	//戦闘ログ処理
	var logCnt = 0;
	var logTimer = setInterval(function(){
		//エフェクト初期化
		$(".enemyDamageEffect").css({
			"top": "50%",
			"opacity": 0,
		});
		
		if(logCnt >= data["log"].length)
		{ //戦闘ログ処理終了時処理
			clearInterval(logTimer);
			//スキルバフアイコン削除
			if(!skillFlg)
			{
				$(".skillBuff").remove();
				$(".skillDebuff").remove();
			}
			$(".commandOverlay").fadeOut();
			isBattle = false;
			// console.log("End");
			
			//戦闘終了時処理
			if(data["battleFlg"])
			{
				var endText = "";
				switch(data["battleFlg"])
				{
					case 1:
						endText = "戦闘に勝利した！<br>";
						endText += data["dropItem"]["name"]+"を"+data["dropItem"]["count"]+"手に入れた！";
						break;
					case 2:
						endText = "戦闘に敗北した";
						break;
				}
				
				//結果出力用モーダルを追加
				$('body').append('<div class="modalEndBattle" id="modalEndBattle"><div class="endText">'+endText+'</div><img src="../img/btn/ok.png" class="modalOk generalBtn" onclick="endBattle('+data['battleFlg']+')"></div>');
				
				openHardModal("modalEndBattle");
			}
		}
		else
		{
			//ログ追加
			$(".logText").prepend(data["log"][logCnt]["message"] + "<br>\n");
			
			switch(data["log"][logCnt]["actor"])
			{
				case 0: //システムアナウンス処理
					// console.log("システムアナウンス");
					if(typeof(data["log"][logCnt]["isWin"]) != "undefined")
					{
						// console.log("戦闘終了");
						if(data["log"][logCnt]["isWin"])
						{
							// console.log("戦闘勝利");
							$(".enemyImg").animate({
								top: "30%",
								opacity: 0,
							}, animateTime*battleSpeed);
						}
					}
					break;
				case 1: //ユーザー行動処理
					// console.log("ユーザー行動");
					switch(data["log"][logCnt]["actionType"])
					{
						case 2: //スキル使用
							switch(data["log"][logCnt]["skill"]["id"])
							{
								case 1: //突撃
									var buffIconHTML = '<div class="buffIcon skillBuff">';
									buffIconHTML += '<img class="buffImg" alt="バフ画像" src="./public/assets/img/battle/buff_attack.png">';
									buffIconHTML += '<div class="buffText">×2</div>';
									buffIconHTML += '</div>';
									$(".buffArea").append(buffIconHTML);
									buffIconHTML = '<div class="buffIcon skillDebuff">';
									buffIconHTML += '<img class="debuffImg" alt="バフ画像" src="./public/assets/img/battle/buff_defence.png">';
									buffIconHTML += '<div class="buffText">×0</div>';
									buffIconHTML += '</div>';
									$(".buffArea").append(buffIconHTML);
									$(".buffIcon").css({
										"width": $(window).outerWidth()*0.08,
										"height": $(window).outerWidth()*0.08,
										"padding-bottom": 0,
									});
									break;
								case 2: //ためる
									skillFlg = 2;
									var buffIconHTML = '<div class="buffIcon skillBuff">';
									buffIconHTML += '<img class="buffImg" alt="バフ画像" src="./public/assets/img/battle/buff_attack.png">';
									buffIconHTML += '<div class="buffText">×2</div>';
									buffIconHTML += '</div>';
									$(".buffArea").append(buffIconHTML);
									$(".buffIcon").css({
										"width": $(window).outerWidth()*0.08,
										"height": $(window).outerWidth()*0.08,
										"padding-bottom": 0,
									});
									break;
							}
							break;
						case 3: //アイテム使用
							var itemType = null;
							switch(data["log"][logCnt]["item"]["type"])
							{
								case 1: //回復アイテム
									itemType = "recover";
									break;
								case 3: //戦闘補助アイテム
									$(".itemBuff").remove();
									var buffIconHTML = '<div class="buffIcon itemBuff">';
									switch(data["log"][logCnt]["item"]["status"])
									{
										case "atk":
											buffIconHTML += '<img class="buffImg" alt="バフ画像" src="./public/assets/img/battle/buff_attack.png">';
											break;
										case "def":
											buffIconHTML += '<img class="buffImg" alt="バフ画像" src="./public/assets/img/battle/buff_defence.png">';
											break;
										case "avd":
											buffIconHTML += '<img class="buffImg" alt="バフ画像" src="./public/assets/img/battle/buff_avoidance.png">';
											break;
									}
									buffIconHTML += '<div class="buffText">×'+data["log"][logCnt]["item"]["value"]+'</div>';
									buffIconHTML += '</div>';
									$(".buffArea").append(buffIconHTML);
									$(".buffIcon").css({
										"width": $(window).outerWidth()*0.08,
										"height": $(window).outerWidth()*0.08,
										"padding-bottom": 0,
									});
									itemType = "battle";
									break;
							}
							if(itemType)
							{
								//アイテム所持数を減らす
								document.getElementById(itemType+data["log"][logCnt]["item"]["id"]+"count").innerHTML -= 1;
								//所持数が0以下になったら削除
								if(document.getElementById(itemType+data["log"][logCnt]["item"]["id"]+"count").innerHTML < 1)
								{
									$("#"+itemType+data["log"][logCnt]["item"]["id"]).remove();
								}
							}
							break;
					}
					//ダメージ判定あり
					if(typeof(data["log"][logCnt]["damage"]) != "undefined")
					{
						var cnt = 0;
						var damageBlink = setInterval(function(){
							cnt++;
							$('.enemyImg').fadeOut(animateTime/5*battleSpeed).fadeIn(animateTime/5*battleSpeed);
							if(cnt>1)
							{
								clearInterval(damageBlink);
							}
						}, animateTime/5*2*battleSpeed);
						//ダメージ量を表示
						$(".enemyDamageEffect").html(data["log"][logCnt]["damage"]).animate({
							top: "40%",
							opacity: 1,
						}, animateTime/2*battleSpeed);
					}
					//回復判定あり
					if(typeof(data["log"][logCnt]["recover"]) != "undefined")
					{
						var userHp = Number(document.getElementById("hp").innerHTML) + Number(data["log"][logCnt]["recover"]);
						if(userHp > Number(document.getElementById("hpMax").innerHTML))
						{
							userHp = document.getElementById("hpMax").innerHTML;
						}
						document.getElementById("hp").innerHTML = userHp;
						$(".hpGaugeBar").css({
							"transition": "all "+(animateTime/10000*5*battleSpeed)+"s ease-in-out",
						});
						changeHpGauge();
					}
					break;
				case 2: //敵行動処理
					// console.log("敵行動");
					if(typeof(data["log"][logCnt]["actionType"]) != "undefined")
					{
						switch(data["log"][logCnt]["actionType"])
						{
							case 0: //通常攻撃
								//敵を拡大する
								$(".enemyImg").css({
									"transition": "all "+(animateTime/10000*3*battleSpeed)+"s ease-in-out",
									"transform": "scale(1.5)",
								}).on("transitionend", function(){
									$(this).css({
										"transform": "",
									}).off("transitionend").on("transitionend", function(){
										$(this).css({
											"transition": "",
										}).off("transitionend");
									});
								});
								break;
						}
					}
					//ダメージ判定あり
					if(typeof(data["log"][logCnt]["damage"]) != "undefined")
					{
						var userHp = document.getElementById("hp").innerHTML - Number(data["log"][logCnt]["damage"]);
						if(userHp < 0)
						{
							userHp = 0;
						}
						document.getElementById("hp").innerHTML = userHp;
						$(".hpGaugeBar").css({
							"transition": "all "+(animateTime/10000*5*battleSpeed)+"s ease-in-out",
						});
						changeHpGauge();
					}
					break;
			}
			// console.log("logCnt:"+logCnt+" length:"+data["log"].length)
			logCnt++;
		}
	}, logInterval*battleSpeed); //ログ処理間隔
}

function endBattle(battleFlg)
{
	location.href = "./battle/end/" + battleFlg;
}

function setLoading()
{
	$(".loadBg").height($(".bgImg").height());
	$(".loadBg").fadeIn();
	$(".battleImg").append('<div class="loadImg"><img src="../img/etc/now_loading.gif"></div>');
}

function unsetLoading()
{
	$(".loadImg").remove();
	$(".loadBg").fadeOut();
}

function openHardModal(contentId)
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
	// 「.modal-close」をクリック
	$('.modalClose').off().click(function(){
		closeModal(contentId);
	});
	// リサイズしたら表示位置を再取得
	$(window).on('resize', function(){
		modalResize(modal);
	});
}

function displayItemRecover()
{
	$(".itemRecover").css({
		"display": "block",
	});
	$(".itemBattle").css({
		"display": "none",
	});
}
function displayItemBattle()
{
	$(".itemRecover").css({
		"display": "none",
	});
	$(".itemBattle").css({
		"display": "block",
	});
}

// function wait(waitTime)
// {
	// var startTime = new Date().getTime();
	// var currentTime = new Date().getTime();
	
	// while((currentTime-currentTime)<waitTime)
	// {
		// currentTime = new Date().getTime();
	// }
// }

function changeHpGauge()
{
	var hp = $("#hp").html();
	var hpMax = $("#hpMax").html();
	// console.log("hp:"+hp+" hpMax:"+hpMax);
	// console.log("hpFrameWidth:"+hpFrameWidth);
	
	$(".hpGaugeBar").css({
		"transition": "all 0.5s ease-in-out",
	});
	$(".hpGaugeBar").css({
		"width": hpBarWidth*(hp/hpMax),
	}).on("transitionend", function(){
		$(this).css({
			"transition": "",
		}).off("transitionend");
	});
	
	// console.log("HP gauge changed");
}

//初期化
function initialize()
{	
	// var ua = navigator.userAgent.toLowerCase();
	// var isFirefox = (ua.indexOf('firefox') > -1);
	
	var windowWidth = $(window).width();
	var windowHeight = $(window).height();
	
	//debug
	// var message = {
		// "windowWidth": windowWidth,
		// "windowHeight": windowHeight,
	// };
	// debugSubmit(message);
	
	var bgImgHeight = windowWidth/16*9;
	var modalWidth = windowWidth*0.9;
	var modalHeight = modalWidth/2*3
	var cheerSize = windowWidth*0.35;
	var commandSize = windowWidth*0.3;
	// console.log("windowWidth:"+windowWidth+" windowHeight:"+windowHeight);
	// console.log("modalWidth:"+modalWidth+" modalHeight:"+modalHeight);
	// if(!isFirefox && (modalHeight > windowHeight))
	if(modalHeight > windowHeight)
	{
		modalHeight = windowHeight;
		modalWidth = modalHeight/3*2;
	}
	//debug
	// console.log("modalWidth2:"+modalWidth+" modalHeight2:"+modalHeight);
	var itemTypeBtnWidth = modalWidth*0.2;
	
	var hpFrameWidth = $(".hpGaugeBattle").width();
	var hpFrameHeight = hpFrameWidth/598*128;
	hpBarWidth = hpFrameWidth*0.82;
	var hpBarHeight = hpBarWidth/496*52;
	
	$(".battleImg").css({
		"height": bgImgHeight,
		"padding-bottom": 0,
	});
	$(".buffIcon").css({
		"width": windowWidth*0.08,
		"height": windowWidth*0.08,
		"padding-bottom": 0,
	});
	$(".hpGaugeBattle").css({
		"height": hpFrameHeight,
	});
	$(".hpGaugeBarImg").css({
		"width": hpBarWidth,
		"height": hpBarHeight,
	});
	$(".hpGaugeBar").css({
		"height": hpBarHeight,
	});
	changeHpGauge();
	
	$(".log").css({
		"width": windowWidth,
		"height": windowWidth*0.3,
	});
	$(".avatarThumnail").css({
		"width": windowWidth*0.3,
		"height": windowWidth*0.3,
		"padding-bottom": 0,
	});
	$(".battleLog").css({
		"width": windowWidth*0.65,
		"height": windowWidth*0.65/2,
		"padding-bottom": 0,
	});
	$(".logText").css({
		"width": windowWidth*0.5,
		"height": windowWidth*0.5/2,
		"padding-bottom": 0,
	});
	
	$(".battleCommand").css({
		"margin-top": 0,
		"padding-bottom": 0,
	});
	$(".commandOverlay").css({
		"top": bgImgHeight,
		"height": windowHeight-bgImgHeight,
	});
	$(".cheerBtn").css({
		"width": cheerSize,
		"height": cheerSize,
		"padding-bottom": 0,
	});
	$(".cheerAvoid").css({
		"top": cheerSize*0.6,
		"left": windowWidth*0.325,
	});
	$(".commandBtn").css({
		"width": commandSize,
		"height": commandSize,
		"top": cheerSize*1.2,
		"padding-bottom": 0,
	});
	
	$(".modalItem").css({
		"width": modalWidth,
		"height": modalHeight,
	});
	$(".itemTypeBtn").css({
		"width": itemTypeBtnWidth,
		"height": itemTypeBtnWidth/320*150,
		"padding-bottom": 0,
	});
	$(".itemData").css({
		"width": modalWidth*0.75,
		"height": modalWidth*0.75/3,
		"padding-bottom": 0,
	});
	
	if($(".itemRecover").length < 1)
	{
		displayItemBattle();
	}
	
	battleSpeed = Number(document.config.battleSpeed.value);
}
$(window).load(function(){
	initialize();
});

function debugSubmit(message)
{
	$.ajax({
		type : 'POST',
		url : './battleapi/debug',
		data : JSON.stringify(message),
		contentType: 'application/JSON',
		dataType : 'JSON',
		scriptCharset: 'utf-8',
		success: function(data){},
		error: function(XMLHttpRequest, textStatus, errorThrown){},
	});
}