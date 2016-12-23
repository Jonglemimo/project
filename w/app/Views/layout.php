<?php include('header.php'); ?>



	<div class="container">
		<header>
			<h1><?= $this->e($title) ?></h1>
		</header>

		<section class=" container">
			<?= $this->section('main_content') ?>
		</section>
	</div>
<?php include ('footer.php'); ?>
		