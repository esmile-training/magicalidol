<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>マジカリドル管理画面</title>
</head>

<body>
	<div id="container">
		<?= Asset::css("admin/common.css"); ?>
		<?= Asset::css("admin/modal.css"); ?>

		<?= View::forge('admin/common/star_link',
				array('str' => '管理画面TOPへ', 'url' => '')
		);?>

		