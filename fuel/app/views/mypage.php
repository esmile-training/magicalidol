<!-- ajax  -->
<button type="button" name="aaa" value="aaa" onClick='connection(<?php echo json_encode($user) ?>, "base/ajax/post_data")'>id=1</button>

<div id="id"></div>
<div id="username"></div>
<div id="created_at"></div>
<div id="updated_at"></div>

<script>
function view(data){
	// タグに情報を付加
	$('#id').text(data['id']);
	$('#username').text(data['name']);
	$('#created_at').text(data['created_at']);
	$('#updated_at').text(data['updated_at']);
}
</script>