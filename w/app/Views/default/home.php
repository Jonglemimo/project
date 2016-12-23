<?php $this->layout('layout', ['title' => 'Accueil']) ?>

<?php $this->start('main_content') ?>
	<h1>Accueil</h1>
	<input type="hidden" id="ajax_search_route" value="<?= $this->url('search') ?>">
	<form action="#" method="POST">
		<label for="search">Recherche : </label>
		<input type="text" name="search" id="search" >
		<button type="submit" id="btnSearch"><i class="glyphicon glyphicon-search"></i></button>
	</form>

	<section id="video">
		
	</section>
<?php $this->stop('main_content') ?>
