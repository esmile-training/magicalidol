var pageLimit = 5;
var pageOffset = Math.floor(pageLimit/2);
var pagerSlideWidth;
var pagerSlideNum;
var pagerSlideSetWidth;
var pagerSliderWidth;
var startPos = 0;
var endPos = 0;
var slideTolerance = 30; //スライド許容範囲(%)
var clickTolerance = 5; //クリック許容範囲半径(px)
// $(function()
// {
	// $(".pager").on('touchstart',touchHandler);
	// $(".pager").on('touchmove',touchHandler);
	// $(".pager").on('touchend',touchHandler);
	// $(".pager").on('touchcancel',touchHandler);
	// $(".pager").on('mousedown',touchHandler);
	// $(".pager").on('mousemove',touchHandler);
	// $(".pager").on('mouseup',touchHandler);
	// $(".pager").on('mouseout',touchHandler);
	
// });

// function touchHandler(e)
// {
	// e.preventDefault();
	// if(e.type == "touchstart")
	// {
		// startPos = e.originalEvent.targetTouches[0].pageX;
	// }
	// if(e.type == "touchmove")
	// {
		// endPos = e.originalEvent.targetTouches[0].pageX;
	// }
	// if(e.type == "touchend")
	// {
		// var offsetX = endPos-startPos;
		//var offsetY = endPosY-startPosY;
		
		// if(Math.abs(offsetX) < clickTolerance)
		// {
			//clickEvent();
		// }
		// else if(offsetX > 0)
		// {
			// pagerSlide(false);
		// }
		// else if(offsetX*-1 > 0)
			// pagerSlide(true);
		
	// }
// }

function pagerSlide(moveLeft)
{
	var move;
	var sliderPosition = $('.pagerSlideSet').position();
	if(moveLeft)
	{
		if(sliderPosition.left <= (-1 * pagerSlideWidth * (pagerSlideNum-pageLimit)))
		{
			return;
		}
		move = "-=";
	}
	else
	{
		if(sliderPosition.left >= 0)
		{
			return;
		}
		move = "+=";
	}
	
	$('.pagerSlideSet').animate({
		left: move+pagerSlideWidth
	});
}

function setupPager(page)
{
	pagerSlideWidth = $('.pagerSlide').outerWidth();
	pagerSlideNum = $('.pagerSlide').length;
	pagerSliderWidth = pagerSlideWidth * pageLimit;
	pagerSlideSetWidth = pagerSlideWidth * pagerSlideNum;
	var slideNum = (page-1)-pageOffset;
	if(slideNum >= pagerSlideNum-pageLimit)
	{
		slideNum = pagerSlideNum-pageLimit;
	}
	if(slideNum < 0)
	{
		slideNum = 0;
	}
	var pagerSlideSetLeft = -1 * pagerSlideWidth * slideNum;
	
	if(pagerSlideNum<pageLimit)
	{
		pagerSliderWidth = pagerSlideWidth * pagerSlideNum;
	}
	$('.pagerSlideSet').css({
		width: pagerSlideSetWidth,
		left: pagerSlideSetLeft,
	});
	$('.pagerSlider').css('width', pagerSliderWidth);
}