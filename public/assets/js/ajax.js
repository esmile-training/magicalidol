// データ受け取り
var object_data;

function connection(url, method)
{
	$(function ()
	{
		$.ajax({
			type:'POST',					// 渡す方法を選択
			url: url,						// 受け取り先を選択
			dataType : 'json',				// データの型
			success: function(data) {
				// jsonデータをオブジェクトに変換
				object_data = JSON.parse(data);
				if(object_data['data']  === false)
				{
					// データがないユーザ表示
					ajax_isnull(object_data);
				}
				else
				{
					object_data.type = method;
					// データがあるユーザ表示
					ajax_binder(object_data);
				}
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
}
