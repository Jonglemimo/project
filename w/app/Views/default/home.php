<?php $this->layout('layout', ['title' => 'Accueil']);

$this->start('main_content');
?>


<input type="hidden" id="ajax_search_route" value="<?= $this->url('search') ?>">

<section id="best">


</section>

<?php $this->stop('main_content') ?>
