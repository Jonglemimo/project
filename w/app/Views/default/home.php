<?php $this->layout('layout', ['title' => 'Accueil', 'categories' => $categories]) ?>

<?php $this->start('main_content') ?>

	<input type="hidden" id="ajax_search_route" value="<?= $this->url('search') ?>">

	<section id="video">
		
	</section>

<?php $this->stop('main_content') ?>
