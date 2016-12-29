<?php include('header.php'); ?>


	<input type="hidden" id="watch_route" value="<?= $this->url('watch') ?>">
	<input type="hidden" id="ajax_search_route" value="<?= $this->url('search') ?>">

	<section class="body body-padding">
		<h1><?= $this->e($title) ?></h1>
		<section>
			<?= $this->section('main_content') ?>
		</section>

	</section>

<?php include ('footer.php'); ?>


