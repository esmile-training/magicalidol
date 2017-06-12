var gaugeWidth = $(window).width()*0.28;

function changeGauge ()
{
	// var gaugeWidth = $(".hpGauge").outerWidth();
	// var gaugeWidth = $(".apGauge").outerWidth();
	
	var hp = document.status.hp.value;
	var hpMax = document.status.hpMax.value;
	var ap = document.status.ap.value;
	var apMax = document.status.apMax.value;
	
	var hpGaugeWidth = gaugeWidth * (hp / hpMax);
	$(".hpGauge").css("width", hpGaugeWidth);
	var apGaugeWidth = gaugeWidth * (ap / apMax);
	$(".apGauge").css("width", apGaugeWidth);
}

function initialize(contentId)
{
	changeGauge();
	openModal(contentId);
}