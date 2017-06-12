function selectChange(presentId)
{
	if(document.getElementById("id"+presentId).value == "0")
	{
		//alert('id'+presentId+'をクリック');
		document.getElementById("id"+presentId).value = presentId;
		$('#content'+presentId).css({
			// backgroundImage: 'url("./public/asset/img/frame/gFrame3-1.png")'
			backgroundImage: $('.presentContent').css('background-image').replace('sFrame3-1.png', 'sFrame3-1-2.png')
		});
	}
	else
	{
		document.getElementById("id"+presentId).value = "0";
		$('#content'+presentId).css({
			// backgroundImage: 'url("./public/asset/img/frame/sFrame3-1.png")'
			backgroundImage: $('.presentContent').css('background-image').replace('sFrame3-1-2.png', 'sFrame3-1.png')
		});
	}
}