function connection()
{
	var data = {
        name: "はじめてのフレームワークとしてのFuelPHP"
    };
	
	$(function ()
	{
		$.ajax({
			type:'POST',
			url: 'http://esmile-sys.sakura.ne.jp/magicalidol/mizugashira/base/ajax.json',
			data: JSON.stringify(data),
			contentType: 'application/json',
			dataType: 'json',
			timeout:1000,
			success: function(data) {
				alert("ok");
			},
			error: function(data) {
				alert("ng");
			}
		});
	});
}


