<?php
$this->layout('layout', ['title' => 'Accueil' , 'categories' => $categories]);
$this->start('main_content');
?>

<!-- SHOWING LATEST FAMOUS VIDEOS -->
<section class="container-fluid video-container">
	<h2>Les plus populaires</h2>
    <div id="resultSearch" class="row col-md-12">

    </div>
</section>

<?php $this->stop('main_content') ?>
