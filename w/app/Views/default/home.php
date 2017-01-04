
<?php $this->layout('layout', ['title' => 'Accueil' , 'categories' => $categories]);


$this->start('main_content');

?>
<input type="hidden" id="ajax_search_route" value="<?= $this->url('search') ?>">


<section class="container-fluid video-container">
    <div id="best" class="col-md-12 row">

    </div>
</section>

<?php $this->stop('main_content') ?>
