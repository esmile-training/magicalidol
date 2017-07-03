var object_data;

function connection(json_data = Array(), url)
{
	$(function ()
	{
		$.ajax({
			type:'POST',					// 渡す方法を選択
			url: url,						// 受け取り先を選択
			dataType : 'json',				// データの型
			data: json_data,				// データ
			success: function(data) {
				// jsonデータをオブジェクトに変換
				object_data = JSON.parse(data);
				view(object_data);
			},
			error: function(data) {
				// error処理
				alert("ng");
			}
		});
	});
}


