<!-- ajax  -->
<button type="button" name="aaa" value="aaa" onClick="connection('base/ajax/post_data/1/masaya', 'user_ajax')">id=<?=$user['id']?></button>

<div id="id"></div>
<div id="username"></div>
<div id="created_at"></div>
<div id="updated_at"></div>

<script>
function ajax_binder(data){
	if(data.type == "user_ajax"){
		// タグに情報を付加
		$('#id').text(data['id']);
		$('#username').text(data['name']);
		$('#created_at').text(data['created_at']);
		$('#updated_at').text(data['updated_at']);
	}
}
</script>