<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>マジカリドル管理画面</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<?php echo Asset::js("ajax.js"); ?>
</head>

<body>
	<div id="container">
		<?= Asset::css("admin/common.css"); ?>
		<?= Asset::css("admin/modal.css"); ?>

		<?= View::forge('admin/common/star_link',
				array('str' => '管理画面TOPへ', 'url' => '')
		);?>

		