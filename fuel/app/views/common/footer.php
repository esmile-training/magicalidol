	<!-- container -->
	</div>
<?= Asset::js("jquery-3.2.1.min.js"); ?>
<?= Asset::js("modal.js"); ?>
	
<?php if($user['developer']): ?>
	<table>
		<tr>
			<td>ユーザID</td>
			<td><?= $user['id']; ?></td>
		</tr>
		<tr>
			<td>名前</td>
			<td><?= $user['name']; ?></td>
		</tr>
		<tr>
			<td>デバッグ日時</td>
			<td><?= $user['nowtime']; ?></td>
		</tr>
	</table>
<?php endif; ?>

</body>
</html>
