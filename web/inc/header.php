<header>
	<div class="user">
		<?php
		if ($user) {
			?>
			<?= "{$user->nom} {$user->prenom}" ?>
			&nbsp;&nbsp;&nbsp;
			[ <a href="logout.php">logout</a> ]
			<?php
		} else {
			?>
			[ <a href="login.php">login</a> ]
			<?php
		}
		?>
	</div>
</header>
