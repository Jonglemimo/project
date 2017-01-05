<?php $this->layout('layout', ['title' => 'Votre recherche', 'categories' => $categories]); 

$this->start('main_content');?>

<h1>Votre recherche ...</h1>

<section id="resultSearch">

</section>

<?php $this->stop('main_content') ?>