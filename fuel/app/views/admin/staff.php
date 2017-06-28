<div style="margin:10px auto; text-align:center;">
	<?php foreach ($staff_list as $job => $member): ?>
		<div style="padding:10px;">
			<div style="font-weight:bold;">
				【<?= $job; ?>】
			</div>
			<?php foreach ($member as $name): ?>
				<div>
					<?= $name; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</div>
