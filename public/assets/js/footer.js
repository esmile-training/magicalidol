$(function()
{
	
	$(".footerUp").click(function()
	{
		$(".footer").animate({"bottom":"0"});
		$(".footerUp").hide();
		$(".footerDown").show();
	});
	$(".footerDown").click(function()
	{
		$(".footer").animate({"bottom":"-12%"});
		$(".footerUp").show();
		$(".footerDown").hide();
	});
});
