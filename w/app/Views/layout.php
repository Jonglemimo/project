
<?php include('header.php'); ?>



	<section class="body body-padding">
		<header>
			<h1><?= $this->e($title) ?></h1>

		</header>

		<section>
			<?= $this->section('main_content') ?>
		</section>
	</section>

<?php include ('footer.php'); ?>
    <?= $this->section('script') ?>

