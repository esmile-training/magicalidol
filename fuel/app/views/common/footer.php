	<!-- container -->
	</div>
<?= Asset::js("jquery-3.2.1.min.js"); ?>
<?= Asset::js("modal.js"); ?>

<?php if($user['developer']): ?>
	<table class="footer_developer">
		<tr>
			<th>ユーザID：</th>
			<td><?= $user['id']; ?></td>
		</tr>
		<tr>
			<th>名前：</th>
			<td><?= $user['name']; ?></td>
		</tr>
		<tr>
			<th>デバッグ日時：</th>
			<td><?= $user['nowtime']; ?></td>
		</tr>
	</table>

	<div>
		<?= Html::anchor(ADMIN_URL, "管理画面へ", array("style" => "color:aqua")); ?>
	</div>
<?php endif; ?>
</body>
</html>
